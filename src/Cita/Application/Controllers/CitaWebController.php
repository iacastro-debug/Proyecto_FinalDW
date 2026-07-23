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
    public function index()
    {
        $citas = CitaEloquentModel::with(['paciente.user', 'medico.user', 'especialidad'])->get();
        return Inertia::render('Cita/index', ['citas' => $citas]);
    }

    public function create()
    {
        $pacientes = PacienteEloquentModel::with('user')->where('activo', true)->get();
        $medicos = MedicoEloquentModel::with('user')->where('activo', true)->get();
        $especialidades = EspecialidadEloquentModel::where('activo', true)->get();
        return Inertia::render('Cita/create', [
            'pacientes' => $pacientes,
            'medicos' => $medicos,
            'especialidades' => $especialidades,
        ]);
    }

    public function store(StoreCitaRequest $request): RedirectResponse
    {
        $data = $request->validated();
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
