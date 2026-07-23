<?php

namespace Src\Medico\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;
use Src\Medico\Infrastructure\Requests\StoreMedicoRequest;
use Src\Medico\Infrastructure\Requests\UpdateMedicoRequest;
use Src\Especialidad\Infrastructure\Models\EspecialidadEloquentModel;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class MedicoWebController extends Controller
{
    public function index()
    {
        $medicos = MedicoEloquentModel::with(['user', 'especialidad'])->get();
        return Inertia::render('Medico/index', ['medicos' => $medicos]);
    }

    public function create()
    {
        $especialidades = EspecialidadEloquentModel::where('activo', true)->get();
        return Inertia::render('Medico/create', ['especialidades' => $especialidades]);
    }

    public function store(StoreMedicoRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = \Src\Auth\Infrastructure\Models\UserEloquentModel::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'medico',
            'activo' => true,
        ]);
        MedicoEloquentModel::create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'user_id' => $user->id,
            'especialidad_id' => $data['especialidad_id'],
            'telefono' => $data['telefono'],
            'numero_registro' => $data['numero_registro'] ?? null,
            'activo' => true,
        ]);
        return redirect()->route('medicos.index')->with('success', 'Médico creado exitosamente');
    }

    public function edit(string $id)
    {
        $medico = MedicoEloquentModel::with('user')->findOrFail($id);
        $especialidades = EspecialidadEloquentModel::where('activo', true)->get();
        return Inertia::render('Medico/edit', ['medico' => $medico, 'especialidades' => $especialidades]);
    }

    public function update(UpdateMedicoRequest $request, string $id): RedirectResponse
    {
        $medico = MedicoEloquentModel::with('user')->findOrFail($id);
        $data = $request->validated();
        if (isset($data['name'])) $medico->user->update(['name' => $data['name']]);
        if (isset($data['email'])) $medico->user->update(['email' => $data['email']]);
        if (isset($data['password'])) $medico->user->update(['password' => bcrypt($data['password'])]);
        $medico->update($data);
        return redirect()->route('medicos.index')->with('success', 'Médico actualizado exitosamente');
    }

    public function destroy(string $id): RedirectResponse
    {
        $medico = MedicoEloquentModel::with('user')->findOrFail($id);
        $medico->user->delete();
        return redirect()->route('medicos.index')->with('success', 'Médico eliminado exitosamente');
    }
}
