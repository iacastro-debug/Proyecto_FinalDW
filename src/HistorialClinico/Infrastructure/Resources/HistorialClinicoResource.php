<?php

namespace Src\HistorialClinico\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistorialClinicoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'citaId' => $this->cita_id,
            'pacienteId' => $this->paciente_id,
            'paciente' => $this->whenLoaded('paciente', fn() => [
                'id' => $this->paciente->id,
                'nombre' => $this->paciente->user?->name,
            ]),
            'medicoId' => $this->medico_id,
            'medico' => $this->whenLoaded('medico', fn() => [
                'id' => $this->medico->id,
                'nombre' => $this->medico->user?->name,
            ]),
            'motivoConsulta' => $this->motivo_consulta,
            'observacionesMedicas' => $this->observaciones_medicas,
            'diagnostico' => $this->diagnostico,
            'indicaciones' => $this->indicaciones,
            'fechaAtencion' => $this->fecha_atencion?->format('Y-m-d H:i:s'),
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
