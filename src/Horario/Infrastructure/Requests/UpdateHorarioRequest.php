<?php

namespace Src\Horario\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHorarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'medico_id' => 'sometimes|required|string|exists:medicos,id',
            'dia' => 'sometimes|required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'sometimes|required|date_format:H:i',
            'hora_fin' => 'sometimes|required|date_format:H:i|after:hora_inicio',
            'intervalo_minutos' => 'nullable|integer|min:15|max:120',
            'activo' => 'nullable|boolean',
        ];
    }
}
