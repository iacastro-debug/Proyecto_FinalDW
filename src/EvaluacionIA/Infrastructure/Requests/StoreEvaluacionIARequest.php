<?php

namespace Src\EvaluacionIA\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluacionIARequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paciente_id' => 'required|string|exists:pacientes,id',
            'edad' => 'nullable|integer|min:0|max:150',
            'genero' => 'nullable|string|max:20',
            'sintomas_principales' => 'required|string|min:10|max:2000',
            'duracion_sintomas' => 'nullable|string|max:255',
            'nivel_dolor' => 'nullable|string|in:bajo,medio,alto',
            'fiebre' => 'nullable|boolean',
            'dificultad_respirar' => 'nullable|boolean',
            'dolor_pecho' => 'nullable|boolean',
            'antecedentes' => 'nullable|string|max:2000',
            'urgencia_percibida' => 'nullable|string|in:baja,media,alta',
            'observaciones' => 'nullable|string|max:2000',
        ];
    }
}
