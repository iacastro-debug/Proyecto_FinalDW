<?php

namespace Src\Especialidad\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEspecialidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean'
        ];
    }
}
