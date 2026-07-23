<?php

namespace Src\Medico\Infrastructure\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\Infrastructure\Models\UserEloquentModel;
use Src\Especialidad\Infrastructure\Models\EspecialidadEloquentModel;

class MedicoEloquentModel extends Model
{
    use HasUuid;

    protected $table = 'medicos';

    protected $fillable = [
        'id',
        'user_id',
        'especialidad_id',
        'telefono',
        'numero_registro',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(EspecialidadEloquentModel::class, 'especialidad_id');
    }
}
