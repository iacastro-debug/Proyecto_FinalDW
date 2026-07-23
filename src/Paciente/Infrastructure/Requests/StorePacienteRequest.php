<?php

namespace Src\Paciente\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePacienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'tipo_documento' => 'required|string|in:DNI,CE,PASAPORTE',
            'numero_documento' => 'required|string|max:20|unique:pacientes,numero_documento',
            'telefono' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|string|in:M,F,Otro',
        ];
    }
}
