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
            'medicamentos' => 'nullable|array',
            'medicamentos.*.nombre' => 'required_with:medicamentos|string|max:255',
            'medicamentos.*.dosis' => 'nullable|string|max:255',
            'medicamentos.*.frecuencia' => 'nullable|string|max:255',
            'medicamentos.*.duracion' => 'nullable|string|max:255',
            'indicaciones' => 'nullable|string|max:5000',
        ];
    }
}
