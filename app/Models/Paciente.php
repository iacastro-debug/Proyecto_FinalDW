<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'direccion',
        'grupo_sanguineo',
        'alergias',
        'enfermedades_cronicas',
        'medicamentos_actuales',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'seguro_medico',
    ];
}