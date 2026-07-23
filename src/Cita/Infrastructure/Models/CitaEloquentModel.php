<?php

namespace Src\Cita\Infrastructure\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;
use Src\Especialidad\Infrastructure\Models\EspecialidadEloquentModel;
use Src\Auth\Infrastructure\Models\UserEloquentModel;

class CitaEloquentModel extends Model
{
    use HasUuid;

    protected $table = 'citas';

    protected $fillable = [
        'id',
        'paciente_id',
        'medico_id',
        'especialidad_id',
        'fecha_cita',
        'hora_cita',
        'estado',
        'motivo_consulta',
        'evaluacion_ia_id',
        'observaciones',
        'created_by',
    ];

    protected $casts = [
        'fecha_cita' => 'date:Y-m-d',
        'hora_cita' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function paciente()
    {
        return $this->belongsTo(PacienteEloquentModel::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(MedicoEloquentModel::class, 'medico_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(EspecialidadEloquentModel::class, 'especialidad_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(UserEloquentModel::class, 'created_by');
    }
}
