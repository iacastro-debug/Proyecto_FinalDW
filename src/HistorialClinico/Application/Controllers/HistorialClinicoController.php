<?php

namespace Src\HistorialClinico\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\HistorialClinico\Infrastructure\Requests\StoreHistorialClinicoRequest;
use Src\HistorialClinico\Infrastructure\Requests\UpdateHistorialClinicoRequest;
use Src\HistorialClinico\Infrastructure\Resources\HistorialClinicoResource;
use Src\HistorialClinico\Infrastructure\Models\HistorialClinicoEloquentModel;
use Src\Cita\Infrastructure\Models\CitaEloquentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HistorialClinicoController extends Controller
{
    public function index(Request $request)
    {
        $query = HistorialClinicoEloquentModel::with(['paciente.user', 'medico.user', 'cita']);

        if ($request->has('paciente_id')) {
            $query->where('paciente_id', $request->paciente_id);
        }

        if ($request->user()->role === 'medico') {
            $medico = \Src\Medico\Infrastructure\Models\MedicoEloquentModel::where('user_id', $request->user()->id)->first();
            if ($medico) {
                $query->where('medico_id', $medico->id);
            }
        }

        $historiales = $query->orderBy('fecha_atencion', 'desc')->get();
        return HistorialClinicoResource::collection($historiales);
    }

    public function store(StoreHistorialClinicoRequest $request)
    {
        $medico = \Src\Medico\Infrastructure\Models\MedicoEloquentModel::where('user_id', $request->user()->id)->first();

        if (!$medico) {
            return response()->json([
                'success' => false,
                'message' => 'Solo los médicos pueden registrar historial clínico'
            ], 403);
        }

        $cita = CitaEloquentModel::find($request->cita_id);
        if ($cita) {
            $cita->update(['estado' => 'atendida']);
        }

        $historial = HistorialClinicoEloquentModel::create([
            'id' => Str::uuid()->toString(),
            'cita_id' => $request->cita_id,
            'paciente_id' => $request->paciente_id,
            'medico_id' => $medico->id,
            'motivo_consulta' => $request->motivo_consulta,
            'observaciones_medicas' => $request->observaciones_medicas,
            'diagnostico' => $request->diagnostico,
            'indicaciones' => $request->indicaciones,
            'fecha_atencion' => now(),
        ]);

        $historial->load(['paciente.user', 'medico.user', 'cita']);
        return new HistorialClinicoResource($historial);
    }

    public function show(string $id)
    {
        $historial = HistorialClinicoEloquentModel::with(['paciente.user', 'medico.user', 'cita'])->find($id);

        if (!$historial) {
            return response()->json([
                'success' => false,
                'message' => 'Historial clínico no encontrado'
            ], 404);
        }

        return new HistorialClinicoResource($historial);
    }

    public function update(UpdateHistorialClinicoRequest $request, string $id)
    {
        $historial = HistorialClinicoEloquentModel::find($id);

        if (!$historial) {
            return response()->json([
                'success' => false,
                'message' => 'Historial clínico no encontrado'
            ], 404);
        }

        $medico = \Src\Medico\Infrastructure\Models\MedicoEloquentModel::where('user_id', $request->user()->id)->first();

        if (!$medico || $medico->id !== $historial->medico_id) {
            return response()->json([
                'success' => false,
                'message' => 'Solo el médico que atendió puede modificar este historial'
            ], 403);
        }

        $historial->update($request->validated());
        $historial->load(['paciente.user', 'medico.user', 'cita']);
        return new HistorialClinicoResource($historial);
    }
}
