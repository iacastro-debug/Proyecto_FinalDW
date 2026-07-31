<?php

namespace Src\Paciente\Infrastructure\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\Infrastructure\Models\UserEloquentModel;

class PacienteEloquentModel extends Model
{
    use HasUuid;

    protected $table = 'pacientes';

    protected $fillable = [
        'id',
        'user_id',
        'nombres',
        'apellidos',
        'email',
        'tipo_documento',
        'numero_documento',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'genero',
        'grupo_sanguineo',
        'alergias',
        'enfermedades_cronicas',
        'medicamentos_actuales',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'seguro_medico',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_nacimiento' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id');
    }
}
