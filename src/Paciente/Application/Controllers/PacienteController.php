<?php

namespace Src\Paciente\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Paciente\Infrastructure\Requests\StorePacienteRequest;
use Src\Paciente\Infrastructure\Requests\UpdatePacienteRequest;
use Src\Paciente\Infrastructure\Resources\PacienteResource;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;
use Src\Auth\Infrastructure\Models\UserEloquentModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = PacienteEloquentModel::with('user')->get();
        return PacienteResource::collection($pacientes);
    }

    public function store(StorePacienteRequest $request)
    {
        $user = UserEloquentModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'paciente',
            'activo' => true,
        ]);

        $paciente = PacienteEloquentModel::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'activo' => true,
        ]);

        $paciente->load('user');
        return new PacienteResource($paciente);
    }

    public function show(string $id)
    {
        $paciente = PacienteEloquentModel::with('user')->find($id);

        if (!$paciente) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        return new PacienteResource($paciente);
    }

    public function update(UpdatePacienteRequest $request, string $id)
    {
        $paciente = PacienteEloquentModel::with('user')->find($id);

        if (!$paciente) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        $userData = [];
        if ($request->has('name')) $userData['name'] = $request->name;
        if ($request->has('email')) $userData['email'] = $request->email;
        if ($request->has('password')) $userData['password'] = Hash::make($request->password);
        if (!empty($userData)) {
            $paciente->user->update($userData);
        }

        $pacienteData = $request->only([
            'tipo_documento', 'numero_documento', 'telefono',
            'direccion', 'fecha_nacimiento', 'genero', 'activo'
        ]);
        $paciente->update($pacienteData);

        $paciente->load('user');
        return new PacienteResource($paciente);
    }

    public function destroy(string $id)
    {
        $paciente = PacienteEloquentModel::find($id);

        if (!$paciente) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        $paciente->user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Paciente eliminado exitosamente'
        ], 200);
    }
}
