<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Medico extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nombre',
        'apellido',
        'especialidad',
        'email',
        'telefono',
        'numero_registro',
        'estado',
    ];
}