<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Src\Auth\Infrastructure\Models\UserEloquentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PacienteController extends Controller
{
    public function index()
    {
        return Inertia::render('Paciente/index', [
            'pacientes' => Paciente::latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Paciente/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'tipo_documento' => 'required',
            'numero_documento' => 'required|unique:pacientes,numero_documento',
            'telefono' => 'nullable|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = UserEloquentModel::create([
            'name' => $validated['nombres'] . ' ' . $validated['apellidos'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'paciente',
            'activo' => true,
        ]);

        Paciente::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id,
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'grupo_sanguineo' => $request->grupo_sanguineo,
            'alergias' => $request->alergias,
            'enfermedades_cronicas' => $request->enfermedades_cronicas,
            'medicamentos_actuales' => $request->medicamentos_actuales,
            'contacto_emergencia_nombre' => $request->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $request->contacto_emergencia_telefono,
            'seguro_medico' => $request->seguro_medico,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'activo' => true,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado correctamente.');
    }

    public function show(string $id)
    {
        $paciente = Paciente::with('user')->findOrFail($id);
        return Inertia::render('Paciente/show', ['paciente' => $paciente]);
    }

    public function edit(string $id)
    {
        $paciente = Paciente::with('user')->findOrFail($id);
        return Inertia::render('Paciente/edit', ['paciente' => $paciente]);
    }

    public function update(Request $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $paciente->user_id,
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'numero_documento' => 'required|unique:pacientes,numero_documento,' . $id,
        ]);

        $paciente->user->update([
            'name' => $validated['nombres'] . ' ' . $validated['apellidos'],
            'email' => $validated['email'],
        ]);

        $paciente->update([
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'grupo_sanguineo' => $request->grupo_sanguineo,
            'alergias' => $request->alergias,
            'enfermedades_cronicas' => $request->enfermedades_cronicas,
            'medicamentos_actuales' => $request->medicamentos_actuales,
            'contacto_emergencia_nombre' => $request->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $request->contacto_emergencia_telefono,
            'seguro_medico' => $request->seguro_medico,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->user->delete();
        $paciente->delete();

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado.');
    }
}
