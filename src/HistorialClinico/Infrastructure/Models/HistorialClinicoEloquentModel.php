<?php

namespace Src\HistorialClinico\Infrastructure\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Src\Cita\Infrastructure\Models\CitaEloquentModel;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;

class HistorialClinicoEloquentModel extends Model
{
    use HasUuid;

    protected $table = 'historiales_clinicos';

    protected $fillable = [
        'id',
        'cita_id',
        'paciente_id',
        'medico_id',
        'motivo_consulta',
        'observaciones_medicas',
        'diagnostico',
        'medicamentos',
        'indicaciones',
        'fecha_atencion',
    ];

    protected $casts = [
        'fecha_atencion' => 'datetime',
        'medicamentos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cita()
    {
        return $this->belongsTo(CitaEloquentModel::class, 'cita_id');
    }

    public function paciente()
    {
        return $this->belongsTo(PacienteEloquentModel::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(MedicoEloquentModel::class, 'medico_id');
    }
}
