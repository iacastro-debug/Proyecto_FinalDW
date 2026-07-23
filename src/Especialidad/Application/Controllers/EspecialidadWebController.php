<?php

namespace Src\Especialidad\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Especialidad\Infrastructure\Models\EspecialidadEloquentModel;
use Src\Especialidad\Infrastructure\Requests\StoreEspecialidadRequest;
use Src\Especialidad\Infrastructure\Requests\UpdateEspecialidadRequest;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class EspecialidadWebController extends Controller
{
    public function index()
    {
        $especialidades = EspecialidadEloquentModel::all();
        return Inertia::render('Especialidad/index', ['especialidades' => $especialidades]);
    }

    public function create()
    {
        return Inertia::render('Especialidad/create');
    }

    public function store(StoreEspecialidadRequest $request): RedirectResponse
    {
        EspecialidadEloquentModel::create($request->validated());
        return redirect()->route('especialidades.index')->with('success', 'Especialidad creada exitosamente');
    }

    public function edit(string $id)
    {
        $especialidad = EspecialidadEloquentModel::findOrFail($id);
        return Inertia::render('Especialidad/edit', ['especialidad' => $especialidad]);
    }

    public function update(UpdateEspecialidadRequest $request, string $id): RedirectResponse
    {
        $especialidad = EspecialidadEloquentModel::findOrFail($id);
        $especialidad->update($request->validated());
        return redirect()->route('especialidades.index')->with('success', 'Especialidad actualizada exitosamente');
    }

    public function destroy(string $id): RedirectResponse
    {
        EspecialidadEloquentModel::findOrFail($id)->delete();
        return redirect()->route('especialidades.index')->with('success', 'Especialidad eliminada exitosamente');
    }
}
