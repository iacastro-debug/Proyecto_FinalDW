<?php

namespace Src\Especialidad\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Especialidad\Infrastructure\Requests\StoreEspecialidadRequest;
use Src\Especialidad\Infrastructure\Requests\UpdateEspecialidadRequest;
use Src\Especialidad\Infrastructure\Resources\EspecialidadResource;
use Src\Especialidad\Infrastructure\Models\EspecialidadEloquentModel;

class EspecialidadController extends Controller
{
    public function index()
    {
        $especialidades = EspecialidadEloquentModel::all();
        return EspecialidadResource::collection($especialidades);
    }

    public function store(StoreEspecialidadRequest $request)
    {
        $especialidad = EspecialidadEloquentModel::create($request->validated());
        return new EspecialidadResource($especialidad);
    }

    public function show(string $id)
    {
        $especialidad = EspecialidadEloquentModel::find($id);

        if (!$especialidad) {
            return response()->json([
                'success' => false,
                'message' => 'Especialidad no encontrada'
            ], 404);
        }

        return new EspecialidadResource($especialidad);
    }

    public function update(UpdateEspecialidadRequest $request, string $id)
    {
        $especialidad = EspecialidadEloquentModel::find($id);

        if (!$especialidad) {
            return response()->json([
                'success' => false,
                'message' => 'Especialidad no encontrada'
            ], 404);
        }

        $especialidad->update($request->validated());
        return new EspecialidadResource($especialidad);
    }

    public function destroy(string $id)
    {
        $especialidad = EspecialidadEloquentModel::find($id);

        if (!$especialidad) {
            return response()->json([
                'success' => false,
                'message' => 'Especialidad no encontrada'
            ], 404);
        }

        $especialidad->delete();

        return response()->json([
            'success' => true,
            'message' => 'Especialidad eliminada exitosamente'
        ], 200);
    }
}
