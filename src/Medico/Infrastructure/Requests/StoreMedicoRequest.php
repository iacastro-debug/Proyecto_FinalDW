<?php

namespace Src\Medico\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicoRequest extends FormRequest
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
            'telefono' => 'required|string|max:20',
            'especialidad_id' => 'required|string|exists:especialidades,id',
            'numero_registro' => 'nullable|string|max:50',
        ];
    }
}
