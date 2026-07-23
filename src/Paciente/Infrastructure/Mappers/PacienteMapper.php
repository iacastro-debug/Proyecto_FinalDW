<?php

namespace Src\Paciente\Infrastructure\Mappers;

use Src\Paciente\Domain\Entities\Paciente;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;

class PacienteMapper
{
    public static function toDomain(PacienteEloquentModel $model): Paciente
    {
        return new Paciente(
            id: $model->id,
            userId: $model->user_id,
            tipoDocumento: $model->tipo_documento,
            numeroDocumento: $model->numero_documento,
            telefono: $model->telefono,
            direccion: $model->direccion,
            fechaNacimiento: $model->fecha_nacimiento?->format('Y-m-d'),
            genero: $model->genero,
            activo: $model->activo,
            createdAt: $model->created_at ? new \DateTimeImmutable($model->created_at->toDateTimeString()) : null,
            updatedAt: $model->updated_at ? new \DateTimeImmutable($model->updated_at->toDateTimeString()) : null
        );
    }
}
