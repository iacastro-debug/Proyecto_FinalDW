<?php

namespace Src\Medico\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Medico\Infrastructure\Requests\StoreMedicoRequest;
use Src\Medico\Infrastructure\Requests\UpdateMedicoRequest;
use Src\Medico\Infrastructure\Resources\MedicoResource;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;
use Src\Auth\Infrastructure\Models\UserEloquentModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MedicoController extends Controller
{
    public function index()
    {
        $medicos = MedicoEloquentModel::with(['user', 'especialidad'])->get();
        return MedicoResource::collection($medicos);
    }

    public function store(StoreMedicoRequest $request)
    {
        $user = UserEloquentModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'medico',
            'activo' => true,
        ]);

        $medico = MedicoEloquentModel::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id,
            'especialidad_id' => $request->especialidad_id,
            'telefono' => $request->telefono,
            'numero_registro' => $request->numero_registro,
            'activo' => true,
        ]);

        $medico->load(['user', 'especialidad']);
        return new MedicoResource($medico);
    }

    public function show(string $id)
    {
        $medico = MedicoEloquentModel::with(['user', 'especialidad'])->find($id);

        if (!$medico) {
            return response()->json([
                'success' => false,
                'message' => 'Médico no encontrado'
            ], 404);
        }

        return new MedicoResource($medico);
    }

    public function update(UpdateMedicoRequest $request, string $id)
    {
        $medico = MedicoEloquentModel::with('user')->find($id);

        if (!$medico) {
            return response()->json([
                'success' => false,
                'message' => 'Médico no encontrado'
            ], 404);
        }

        $userData = [];
        if ($request->has('name')) $userData['name'] = $request->name;
        if ($request->has('email')) $userData['email'] = $request->email;
        if ($request->has('password')) $userData['password'] = Hash::make($request->password);
        if (!empty($userData)) {
            $medico->user->update($userData);
        }

        $medicoData = $request->only(['especialidad_id', 'telefono', 'numero_registro', 'activo']);
        $medico->update($medicoData);

        $medico->load(['user', 'especialidad']);
        return new MedicoResource($medico);
    }

    public function destroy(string $id)
    {
        $medico = MedicoEloquentModel::find($id);

        if (!$medico) {
            return response()->json([
                'success' => false,
                'message' => 'Médico no encontrado'
            ], 404);
        }

        $medico->user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Médico eliminado exitosamente'
        ], 200);
    }
}
