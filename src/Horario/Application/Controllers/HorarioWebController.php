<?php

namespace Src\Horario\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Horario\Infrastructure\Models\HorarioEloquentModel;
use Src\Horario\Infrastructure\Requests\StoreHorarioRequest;
use Src\Horario\Infrastructure\Requests\UpdateHorarioRequest;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class HorarioWebController extends Controller
{
    public function index()
    {
        $query = HorarioEloquentModel::with('medico.user');

        if (auth()->user()->role === 'medico') {
            $medico = MedicoEloquentModel::where('user_id', auth()->id())->first();
            if ($medico) {
                $query->where('medico_id', $medico->id);
            }
        }

        $horarios = $query->orderBy('dia')->orderBy('hora_inicio')->get();
        return Inertia::render('Horario/index', ['horarios' => $horarios]);
    }

    public function create()
    {
        $medicos = MedicoEloquentModel::with('user')->where('activo', true)->get();
        return Inertia::render('Horario/create', ['medicos' => $medicos]);
    }

    public function store(StoreHorarioRequest $request): RedirectResponse
    {
        HorarioEloquentModel::create($request->validated());
        return redirect()->route('horarios.index')->with('success', 'Horario creado exitosamente');
    }

    public function edit(string $id)
    {
        $horario = HorarioEloquentModel::findOrFail($id);
        $medicos = MedicoEloquentModel::with('user')->where('activo', true)->get();
        return Inertia::render('Horario/edit', ['horario' => $horario, 'medicos' => $medicos]);
    }

    public function update(UpdateHorarioRequest $request, string $id): RedirectResponse
    {
        HorarioEloquentModel::findOrFail($id)->update($request->validated());
        return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente');
    }

    public function destroy(string $id): RedirectResponse
    {
        HorarioEloquentModel::findOrFail($id)->delete();
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado exitosamente');
    }
}
