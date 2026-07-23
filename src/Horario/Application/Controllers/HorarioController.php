<?php

namespace Src\Horario\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Horario\Infrastructure\Requests\StoreHorarioRequest;
use Src\Horario\Infrastructure\Requests\UpdateHorarioRequest;
use Src\Horario\Infrastructure\Resources\HorarioResource;
use Src\Horario\Infrastructure\Models\HorarioEloquentModel;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = HorarioEloquentModel::with('medico.user')->get();
        return HorarioResource::collection($horarios);
    }

    public function store(StoreHorarioRequest $request)
    {
        $horario = HorarioEloquentModel::create($request->validated());
        $horario->load('medico.user');
        return new HorarioResource($horario);
    }

    public function show(string $id)
    {
        $horario = HorarioEloquentModel::with('medico.user')->find($id);

        if (!$horario) {
            return response()->json([
                'success' => false,
                'message' => 'Horario no encontrado'
            ], 404);
        }

        return new HorarioResource($horario);
    }

    public function update(UpdateHorarioRequest $request, string $id)
    {
        $horario = HorarioEloquentModel::find($id);

        if (!$horario) {
            return response()->json([
                'success' => false,
                'message' => 'Horario no encontrado'
            ], 404);
        }

        $horario->update($request->validated());
        $horario->load('medico.user');
        return new HorarioResource($horario);
    }

    public function destroy(string $id)
    {
        $horario = HorarioEloquentModel::find($id);

        if (!$horario) {
            return response()->json([
                'success' => false,
                'message' => 'Horario no encontrado'
            ], 404);
        }

        $horario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Horario eliminado exitosamente'
        ], 200);
    }
}
