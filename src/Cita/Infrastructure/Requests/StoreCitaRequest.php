<?php

namespace Src\Cita\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paciente_id' => 'required|string|exists:pacientes,id',
            'medico_id' => 'required|string|exists:medicos,id',
            'especialidad_id' => 'required|string|exists:especialidades,id',
            'fecha_cita' => 'required|date|after_or_equal:today',
            'hora_cita' => 'required|date_format:H:i',
            'motivo_consulta' => 'nullable|string',
            'evaluacion_ia_id' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ];
    }
}
