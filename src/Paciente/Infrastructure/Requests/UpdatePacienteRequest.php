<?php

namespace Src\Paciente\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePacienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pacienteId = $this->route('paciente');

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $pacienteId,
            'password' => 'nullable|string|min:8',
            'tipo_documento' => 'sometimes|required|string|in:DNI,CE,PASAPORTE',
            'numero_documento' => 'sometimes|required|string|max:20|unique:pacientes,numero_documento,' . $pacienteId,
            'telefono' => 'sometimes|required|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|string|in:M,F,Otro',
            'activo' => 'nullable|boolean',
        ];
    }
}
