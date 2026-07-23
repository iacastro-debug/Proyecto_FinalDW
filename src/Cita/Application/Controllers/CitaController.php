<?php

namespace Src\Cita\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Cita\Infrastructure\Requests\StoreCitaRequest;
use Src\Cita\Infrastructure\Requests\UpdateCitaRequest;
use Src\Cita\Infrastructure\Resources\CitaResource;
use Src\Cita\Infrastructure\Models\CitaEloquentModel;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index(Request $request)
    {
        $query = CitaEloquentModel::with(['paciente.user', 'medico.user', 'especialidad']);

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('medico_id')) {
            $query->where('medico_id', $request->medico_id);
        }

        if ($request->has('paciente_id')) {
            $query->where('paciente_id', $request->paciente_id);
        }

        if ($request->has('fecha_desde')) {
            $query->where('fecha_cita', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta')) {
            $query->where('fecha_cita', '<=', $request->fecha_hasta);
        }

        $citas = $query->orderBy('fecha_cita')->orderBy('hora_cita')->get();
        return CitaResource::collection($citas);
    }

    public function store(StoreCitaRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        $cita = CitaEloquentModel::create($data);
        $cita->load(['paciente.user', 'medico.user', 'especialidad']);
        return new CitaResource($cita);
    }

    public function show(string $id)
    {
        $cita = CitaEloquentModel::with(['paciente.user', 'medico.user', 'especialidad'])->find($id);

        if (!$cita) {
            return response()->json([
                'success' => false,
                'message' => 'Cita no encontrada'
            ], 404);
        }

        return new CitaResource($cita);
    }

    public function update(UpdateCitaRequest $request, string $id)
    {
        $cita = CitaEloquentModel::find($id);

        if (!$cita) {
            return response()->json([
                'success' => false,
                'message' => 'Cita no encontrada'
            ], 404);
        }

        $cita->update($request->validated());
        $cita->load(['paciente.user', 'medico.user', 'especialidad']);
        return new CitaResource($cita);
    }

    public function destroy(string $id)
    {
        $cita = CitaEloquentModel::find($id);

        if (!$cita) {
            return response()->json([
                'success' => false,
                'message' => 'Cita no encontrada'
            ], 404);
        }

        $cita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cita eliminada exitosamente'
        ], 200);
    }

    public function cancelar(Request $request, string $id)
    {
        $cita = CitaEloquentModel::find($id);

        if (!$cita) {
            return response()->json([
                'success' => false,
                'message' => 'Cita no encontrada'
            ], 404);
        }

        $cita->update([
            'estado' => 'cancelada',
            'observaciones' => $request->input('observaciones', $cita->observaciones)
        ]);

        $cita->load(['paciente.user', 'medico.user', 'especialidad']);
        return new CitaResource($cita);
    }
}
