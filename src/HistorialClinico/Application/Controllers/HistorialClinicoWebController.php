<?php

namespace Src\HistorialClinico\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\HistorialClinico\Infrastructure\Models\HistorialClinicoEloquentModel;
use Src\HistorialClinico\Infrastructure\Requests\StoreHistorialClinicoRequest;
use Src\HistorialClinico\Infrastructure\Requests\UpdateHistorialClinicoRequest;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;
use Src\Cita\Infrastructure\Models\CitaEloquentModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistorialClinicoWebController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = HistorialClinicoEloquentModel::with(['paciente.user', 'medico.user', 'cita']);

        if ($user->role === 'medico') {
            $medico = MedicoEloquentModel::where('user_id', $user->id)->first();
            if ($medico) {
                $query->where('medico_id', $medico->id);
            }
        } elseif ($user->role === 'paciente') {
            $paciente = PacienteEloquentModel::where('user_id', $user->id)->first();
            if ($paciente) {
                $query->where('paciente_id', $paciente->id);
            }
        }

        $historiales = $query->orderBy('fecha_atencion', 'desc')->get();
        return Inertia::render('HistorialClinico/index', ['historiales' => $historiales]);
    }

    public function create(?string $citaId = null)
    {
        $user = auth()->user();
        $medico = MedicoEloquentModel::where('user_id', $user->id)->first();

        $cita = null;
        $citas = CitaEloquentModel::with('paciente.user')->where('estado', '!=', 'cancelada')->get();

        if ($citaId) {
            $cita = $citas->firstWhere('id', $citaId);
            if ($medico && $cita && $cita->medico_id !== $medico->id) {
                return redirect()->route('historiales-clinicos.index')
                    ->with('error', 'Esta cita no te pertenece.');
            }
        }

        if ($medico) {
            $citas = $citas->where('medico_id', $medico->id)->values();
        }

        $pacientes = PacienteEloquentModel::with('user')->get();

        return Inertia::render('HistorialClinico/create', [
            'medico' => $medico,
            'cita' => $cita,
            'pacientes' => $pacientes,
            'citas' => $citas,
        ]);
    }

    public function store(StoreHistorialClinicoRequest $request)
    {
        $user = auth()->user();
        $medico = MedicoEloquentModel::where('user_id', $user->id)->first();

        $cita = CitaEloquentModel::find($request->cita_id);
        if ($cita) {
            $medico = MedicoEloquentModel::find($cita->medico_id);
        }

        if (!$medico) {
            return redirect()->route('historiales-clinicos.index')
                ->with('error', 'No se encontró un médico para esta cita.');
        }

        if ($cita) {
            $cita->update(['estado' => 'atendida']);
        }

        HistorialClinicoEloquentModel::create([
            'id' => Str::uuid()->toString(),
            'cita_id' => $request->cita_id,
            'paciente_id' => $request->paciente_id,
            'medico_id' => $medico->id,
            'motivo_consulta' => $request->motivo_consulta,
            'observaciones_medicas' => $request->observaciones_medicas,
            'diagnostico' => $request->diagnostico,
            'medicamentos' => $request->medicamentos,
            'indicaciones' => $request->indicaciones,
            'fecha_atencion' => now(),
        ]);

        return redirect()->route('historiales-clinicos.index')
            ->with('success', 'Historial clínico registrado exitosamente.');
    }

    public function show(string $id)
    {
        $historial = HistorialClinicoEloquentModel::with(['paciente.user', 'medico.user', 'cita'])->findOrFail($id);
        return Inertia::render('HistorialClinico/show', ['historial' => $historial]);
    }

    public function edit(string $id)
    {
        $user = auth()->user();
        $medico = MedicoEloquentModel::where('user_id', $user->id)->first();

        if (!$medico) {
            return redirect()->route('historiales-clinicos.index')
                ->with('error', 'Solo los médicos pueden editar historiales clínicos.');
        }

        $historial = HistorialClinicoEloquentModel::findOrFail($id);

        if ($historial->medico_id !== $medico->id) {
            return redirect()->route('historiales-clinicos.index')
                ->with('error', 'Solo el médico que atendió puede modificar este historial.');
        }

        return Inertia::render('HistorialClinico/edit', [
            'historial' => $historial,
            'medico' => $medico,
        ]);
    }

    public function update(UpdateHistorialClinicoRequest $request, string $id)
    {
        $user = auth()->user();
        $medico = MedicoEloquentModel::where('user_id', $user->id)->first();

        if (!$medico) {
            return redirect()->route('historiales-clinicos.index')
                ->with('error', 'Solo los médicos pueden editar historiales clínicos.');
        }

        $historial = HistorialClinicoEloquentModel::findOrFail($id);

        if ($historial->medico_id !== $medico->id) {
            return redirect()->route('historiales-clinicos.index')
                ->with('error', 'Solo el médico que atendió puede modificar este historial.');
        }

        $historial->update($request->validated());

        return redirect()->route('historiales-clinicos.index')
            ->with('success', 'Historial clínico actualizado exitosamente.');
    }
}
