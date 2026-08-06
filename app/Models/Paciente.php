<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\Infrastructure\Models\UserEloquentModel;

class Paciente extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pacientes';

    protected $fillable = [
        'id',
        'user_id',
        'nombres',
        'apellidos',
        'email',
        'tipo_documento',
        'numero_documento',
        'fecha_nacimiento',
        'genero',
        'grupo_sanguineo',
        'alergias',
        'enfermedades_cronicas',
        'medicamentos_actuales',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'seguro_medico',
        'telefono',
        'direccion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_nacimiento' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id');
    }

   

}
