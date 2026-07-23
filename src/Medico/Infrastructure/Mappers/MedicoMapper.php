<?php

namespace Src\Medico\Infrastructure\Mappers;

use Src\Medico\Domain\Entities\Medico;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;

class MedicoMapper
{
    public static function toDomain(MedicoEloquentModel $model): Medico
    {
        return new Medico(
            id: $model->id,
            userId: $model->user_id,
            especialidadId: $model->especialidad_id,
            telefono: $model->telefono,
            numeroRegistro: $model->numero_registro,
            activo: $model->activo,
            createdAt: $model->created_at ? new \DateTimeImmutable($model->created_at->toDateTimeString()) : null,
            updatedAt: $model->updated_at ? new \DateTimeImmutable($model->updated_at->toDateTimeString()) : null
        );
    }
}
