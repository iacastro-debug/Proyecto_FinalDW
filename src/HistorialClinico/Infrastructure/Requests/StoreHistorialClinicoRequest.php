<?php

namespace Src\HistorialClinico\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHistorialClinicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cita_id' => 'required|string|exists:citas,id',
            'paciente_id' => 'required|string|exists:pacientes,id',
            'motivo_consulta' => 'required|string|max:2000',
            'observaciones_medicas' => 'nullable|string|max:5000',
            'diagnostico' => 'required|string|max:5000',
            'indicaciones' => 'nullable|string|max:5000',
        ];
    }
}
