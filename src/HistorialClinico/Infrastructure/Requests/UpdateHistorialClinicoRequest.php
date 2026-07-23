<?php

namespace Src\HistorialClinico\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHistorialClinicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'motivo_consulta' => 'sometimes|required|string|max:2000',
            'observaciones_medicas' => 'nullable|string|max:5000',
            'diagnostico' => 'sometimes|required|string|max:5000',
            'indicaciones' => 'nullable|string|max:5000',
        ];
    }
}
