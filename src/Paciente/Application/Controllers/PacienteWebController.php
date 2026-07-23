<?php

namespace Src\Paciente\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;
use Src\Paciente\Infrastructure\Requests\StorePacienteRequest;
use Src\Paciente\Infrastructure\Requests\UpdatePacienteRequest;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class PacienteWebController extends Controller
{
    public function index()
    {
        $pacientes = PacienteEloquentModel::with('user')->get();
        return Inertia::render('Paciente/index', ['pacientes' => $pacientes]);
    }

    public function create()
    {
        return Inertia::render('Paciente/create');
    }

    public function store(StorePacienteRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = \Src\Auth\Infrastructure\Models\UserEloquentModel::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'paciente',
            'activo' => true,
        ]);
        PacienteEloquentModel::create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'user_id' => $user->id,
            'tipo_documento' => $data['tipo_documento'],
            'numero_documento' => $data['numero_documento'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'] ?? null,
            'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
            'genero' => $data['genero'] ?? null,
            'activo' => true,
        ]);
        return redirect()->route('pacientes.index')->with('success', 'Paciente creado exitosamente');
    }

    public function show(string $id)
    {
        $paciente = PacienteEloquentModel::with('user')->findOrFail($id);
        return Inertia::render('Paciente/show', ['paciente' => $paciente]);
    }

    public function edit(string $id)
    {
        $paciente = PacienteEloquentModel::with('user')->findOrFail($id);
        return Inertia::render('Paciente/edit', ['paciente' => $paciente]);
    }

    public function update(UpdatePacienteRequest $request, string $id): RedirectResponse
    {
        $paciente = PacienteEloquentModel::with('user')->findOrFail($id);
        $data = $request->validated();
        if (isset($data['name'])) {
            $paciente->user->update(['name' => $data['name']]);
        }
        if (isset($data['email'])) {
            $paciente->user->update(['email' => $data['email']]);
        }
        $paciente->update($data);
        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado exitosamente');
    }

    public function destroy(string $id): RedirectResponse
    {
        $paciente = PacienteEloquentModel::with('user')->findOrFail($id);
        $paciente->user->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado exitosamente');
    }
}
