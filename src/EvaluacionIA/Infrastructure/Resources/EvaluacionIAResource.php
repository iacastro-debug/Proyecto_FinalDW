<?php

namespace Src\EvaluacionIA\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluacionIAResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pacienteId' => $this->paciente_id,
            'paciente' => $this->whenLoaded('paciente', fn() => [
                'id' => $this->paciente->id,
                'nombre' => $this->paciente->user?->name,
            ]),
            'edad' => $this->edad,
            'sintomasPrincipales' => $this->sintomas_principales,
            'duracionSintomas' => $this->duracion_sintomas,
            'nivelDolor' => $this->nivel_dolor,
            'fiebre' => $this->fiebre,
            'dificultadRespirar' => $this->dificultad_respirar,
            'dolorPecho' => $this->dolor_pecho,
            'antecedentes' => $this->antecedentes,
            'urgenciaPercibida' => $this->urgencia_percibida,
            'especialidadSugerida' => $this->especialidad_sugerida,
            'prioridad' => $this->prioridad,
            'motivo' => $this->motivo,
            'advertencia' => $this->advertencia,
            'estado' => $this->estado,
            'modoSimulado' => $this->modo_simulado,
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
