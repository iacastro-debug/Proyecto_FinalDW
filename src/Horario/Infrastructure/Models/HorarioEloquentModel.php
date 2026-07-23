<?php

namespace Src\Horario\Infrastructure\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;

class HorarioEloquentModel extends Model
{
    use HasUuid;

    protected $table = 'horarios';

    protected $fillable = [
        'id',
        'medico_id',
        'dia',
        'hora_inicio',
        'hora_fin',
        'intervalo_minutos',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'hora_inicio' => 'string',
        'hora_fin' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function medico()
    {
        return $this->belongsTo(MedicoEloquentModel::class, 'medico_id');
    }
}
