<?php

namespace Src\Cita\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paciente_id' => 'sometimes|required|string|exists:pacientes,id',
            'medico_id' => 'sometimes|required|string|exists:medicos,id',
            'especialidad_id' => 'sometimes|required|string|exists:especialidades,id',
            'fecha_cita' => 'sometimes|required|date',
            'hora_cita' => 'sometimes|required|date_format:H:i',
            'estado' => 'sometimes|required|string|in:pendiente,confirmada,atendida,cancelada,reprogramada,no_asistio',
            'motivo_consulta' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ];
    }
}
