<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Traits\HasRoles;

class Medico extends Model
{
    use HasFactory, HasUuids, HasRoles; // <--- Agrega HasRoles aquí

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