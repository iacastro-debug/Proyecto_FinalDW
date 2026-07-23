<?php

namespace Src\Medico\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->route('medico'),
            'password' => 'nullable|string|min:8',
            'telefono' => 'sometimes|required|string|max:20',
            'especialidad_id' => 'sometimes|required|string|exists:especialidades,id',
            'numero_registro' => 'nullable|string|max:50',
            'activo' => 'nullable|boolean',
        ];
    }
}
