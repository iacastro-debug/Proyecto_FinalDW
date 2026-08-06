<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Src\Auth\Infrastructure\Models\UserEloquentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PacienteController extends Controller
{
    /**
     * Muestra la lista de pacientes con búsqueda y paginación.
     */
    public function index(Request $request)
    {
        $query = Paciente::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%")
                  ->orWhere('numero_documento', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo_documento')) {
            $query->where('tipo_documento', $request->input('tipo_documento'));
        }

        return Inertia::render('Paciente/Index', [
            'pacientes' => $query->latest()->paginate(10)->withQueryString(),
            'filters'   => $request->only(['search', 'tipo_documento']),
        ]);
    }

    /**
     * Muestra el formulario para registrar un paciente.
     */
    public function create()
    {
        return Inertia::render('Paciente/Create');
    }

    public function show(Paciente $paciente)
    {
    return Inertia::render('Paciente/Show', [
        'paciente' => $paciente->load('user')
    ]);
    }

    /**
     * Guarda el paciente y crea su usuario asociado usando tus imports.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres'          => 'required|string|max:100',
            'apellidos'        => 'required|string|max:100',
            'tipo_documento'   => 'required|string|max:20',
            'numero_documento' => 'required|string|max:30|unique:pacientes,numero_documento',
            'email'            => 'required|email|max:150|unique:users,email',
            'password'         => 'nullable|string|min:8',
            'telefono'         => 'nullable|string|max:20',
            'direccion'        => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'activo'           => 'boolean',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Crear el registro en la tabla de usuarios de tu arquitectura
            $user = UserEloquentModel::create([
                'name'     => $validated['nombres'] . ' ' . $validated['apellidos'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password'] ?? Str::random(10)),
            ]);

            // 2. Crear el paciente vinculado al ID del usuario
            Paciente::create([
                'user_id'          => $user->id,
                'nombres'          => $validated['nombres'],
                'apellidos'        => $validated['apellidos'],
                'tipo_documento'   => $validated['tipo_documento'],
                'numero_documento' => $validated['numero_documento'],
                'email'            => $validated['email'],
                'telefono'         => $validated['telefono'] ?? null,
                'direccion'        => $validated['direccion'] ?? null,
                'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
                'activo'           => $validated['activo'] ?? true,
            ]);
        });

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente registrado correctamente.');
    }

    /**
     * Muestra el formulario para editar el paciente.
     */
    public function edit(Paciente $paciente)
    {
        return Inertia::render('Paciente/Edit', [
            'paciente' => $paciente->load('user'),
        ]);
    }

    /**
     * Actualiza la información del paciente y de su usuario.
     */
    public function update(Request $request, Paciente $paciente)
{
    $validated = $request->validate([
        'nombres'                      => 'required|string|max:100',
        'apellidos'                    => 'required|string|max:100',
        'tipo_documento'               => 'required|string|max:20',
        'numero_documento'             => 'required|string|max:30|unique:pacientes,numero_documento,' . $paciente->id,
        'email'                        => 'required|email|max:150|unique:users,email,' . $paciente->user_id,
        'telefono'                     => 'nullable|string|max:20',
        'direccion'                    => 'nullable|string|max:255',
        'fecha_nacimiento'             => 'nullable|date',
        'activo'                       => 'boolean',

        // 🟢 CAMPOS MÉDICOS Y DE EMERGENCIA AGREGADOS
        'grupo_sanguineo'              => 'nullable|string|max:10',
        'seguro_medico'                => 'nullable|string|max:100',
        'alergias'                     => 'nullable|string',
        'enfermedades_cronicas'        => 'nullable|string',
        'medicamentos_actuales'        => 'nullable|string',
        'contacto_emergencia_nombre'   => 'nullable|string|max:150',
        'contacto_emergencia_telefono' => 'nullable|string|max:20',
    ]);

    DB::transaction(function () use ($paciente, $validated) {
        // Actualizar usuario asociado
        if ($paciente->user_id) {
            UserEloquentModel::where('id', $paciente->user_id)->update([
                'name'  => $validated['nombres'] . ' ' . $validated['apellidos'],
                'email' => $validated['email'],
            ]);
        }

        // Ahora $validated sí contiene los datos médicos y se guardan en la BD
        $paciente->update($validated);
    });

    return redirect()->route('pacientes.index')
        ->with('success', 'Paciente actualizado correctamente.');
}

    /**
     * Elimina al paciente y a su usuario correspondiente.
     */
    public function destroy(Paciente $paciente)
    {
        DB::transaction(function () use ($paciente) {
            $userId = $paciente->user_id;
            $paciente->delete();

            if ($userId) {
                UserEloquentModel::destroy($userId);
            }
        });

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado correctamente.');
    }
}