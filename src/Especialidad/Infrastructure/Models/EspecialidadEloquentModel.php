<?php

namespace Src\Especialidad\Infrastructure\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class EspecialidadEloquentModel extends Model
{
    use HasUuid;

    protected $table = 'especialidades';

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
