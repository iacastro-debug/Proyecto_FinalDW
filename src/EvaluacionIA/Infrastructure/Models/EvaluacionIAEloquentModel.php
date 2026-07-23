<?php

namespace Src\EvaluacionIA\Infrastructure\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;

class EvaluacionIAEloquentModel extends Model
{
    use HasUuid;

    protected $table = 'evaluaciones_ia';

    protected $fillable = [
        'id',
        'paciente_id',
        'edad',
        'genero',
        'sintomas_principales',
        'duracion_sintomas',
        'nivel_dolor',
        'fiebre',
        'dificultad_respirar',
        'dolor_pecho',
        'antecedentes',
        'urgencia_percibida',
        'observaciones',
        'especialidad_sugerida',
        'prioridad',
        'motivo',
        'advertencia',
        'respuesta_raw',
        'estado',
        'modo_simulado',
    ];

    protected $casts = [
        'fiebre' => 'boolean',
        'dificultad_respirar' => 'boolean',
        'dolor_pecho' => 'boolean',
        'modo_simulado' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function paciente()
    {
        return $this->belongsTo(PacienteEloquentModel::class, 'paciente_id');
    }
}
