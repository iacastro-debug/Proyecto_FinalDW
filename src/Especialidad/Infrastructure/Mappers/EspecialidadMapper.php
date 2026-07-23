<?php

namespace Src\Especialidad\Infrastructure\Mappers;

use Src\Especialidad\Domain\Entities\Especialidad;
use Src\Especialidad\Infrastructure\Models\EspecialidadEloquentModel;

class EspecialidadMapper
{
    public static function toDomain(EspecialidadEloquentModel $model): Especialidad
    {
        return new Especialidad(
            id: $model->id,
            nombre: $model->nombre,
            descripcion: $model->descripcion,
            activo: $model->activo,
            createdAt: $model->created_at ? new \DateTimeImmutable($model->created_at->toDateTimeString()) : null,
            updatedAt: $model->updated_at ? new \DateTimeImmutable($model->updated_at->toDateTimeString()) : null
        );
    }

    public static function toEloquent(Especialidad $especialidad): EspecialidadEloquentModel
    {
        $model = new EspecialidadEloquentModel();
        $model->id = $especialidad->getId();
        $model->nombre = $especialidad->getNombre();
        $model->descripcion = $especialidad->getDescripcion();
        $model->activo = $especialidad->getActivo();
        return $model;
    }

    public static function updateEloquentFromDomain(EspecialidadEloquentModel $model, Especialidad $especialidad): void
    {
        $model->nombre = $especialidad->getNombre();
        $model->descripcion = $especialidad->getDescripcion();
        $model->activo = $especialidad->getActivo();
    }
}
