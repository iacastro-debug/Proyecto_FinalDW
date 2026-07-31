<?php

namespace Src\Cita\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Cita\Infrastructure\Models\CitaEloquentModel;
use Src\Cita\Infrastructure\Requests\StoreCitaRequest;
use Src\Cita\Infrastructure\Requests\UpdateCitaRequest;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;
use Src\Especialidad\Infrastructure\Models\EspecialidadEloquentModel;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class CitaWebController extends Controller
{
    private function medicoActual()
    {
        return MedicoEloquentModel::where('user_id', auth()->id())->first();
    }

    private function pacienteActual()
    {
        return PacienteEloquentModel::where('user_id', auth()->id())->first();
    }

    public function index()
    {
        $query = CitaEloquentModel::with(['paciente.user', 'medico.user', 'especialidad']);

        if (auth()->user()->role === 'medico') {
            $medico = $this->medicoActual();
            if ($medico) {
                $query->where('medico_id', $medico->id);
            }
        } elseif (auth()->user()->role === 'paciente') {
            $paciente = $this->pacienteActual();
            if ($paciente) {
                $query->where('paciente_id', $paciente->id);
            }
        }

        $citas = $query->orderBy('fecha_cita', 'desc')->get();
        return Inertia::render('Cita/index', ['citas' => $citas]);
    }

    public function create()
    {
        $pacientes = PacienteEloquentModel::with('user')->where('activo', true);
        $medicos = MedicoEloquentModel::with('user')->where('activo', true)->get();
        $especialidades = EspecialidadEloquentModel::where('activo', true)->get();

        $pacienteActual = null;
        if (auth()->user()->role === 'paciente') {
            $pacienteActual = $this->pacienteActual();
            if ($pacienteActual) {
                $pacientes = $pacientes->where('id', $pacienteActual->id);
            }
        }
        $pacientes = $pacientes->get();

        return Inertia::render('Cita/create', [
            'pacientes' => $pacientes,
            'medicos' => $medicos,
            'especialidades' => $especialidades,
            'pacienteActual' => $pacienteActual,
        ]);
    }

    public function store(StoreCitaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (auth()->user()->role === 'paciente') {
            $paciente = $this->pacienteActual();
            if (!$paciente) {
                return redirect()->route('citas.create')->with('error', 'No se encontró tu perfil de paciente.');
            }
            $data['paciente_id'] = $paciente->id;
        }
        $data['created_by'] = auth()->id();
        CitaEloquentModel::create($data);
        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente');
    }

    public function edit(string $id)
    {
        $cita = CitaEloquentModel::findOrFail($id);
        $pacientes = PacienteEloquentModel::with('user')->where('activo', true)->get();
        $medicos = MedicoEloquentModel::with('user')->where('activo', true)->get();
        $especialidades = EspecialidadEloquentModel::where('activo', true)->get();
        return Inertia::render('Cita/edit', [
            'cita' => $cita,
            'pacientes' => $pacientes,
            'medicos' => $medicos,
            'especialidades' => $especialidades,
        ]);
    }

    public function update(UpdateCitaRequest $request, string $id): RedirectResponse
    {
        CitaEloquentModel::findOrFail($id)->update($request->validated());
        return redirect()->route('citas.index')->with('success', 'Cita actualizada exitosamente');
    }

    public function destroy(string $id): RedirectResponse
    {
        CitaEloquentModel::findOrFail($id)->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada exitosamente');
    }
}
