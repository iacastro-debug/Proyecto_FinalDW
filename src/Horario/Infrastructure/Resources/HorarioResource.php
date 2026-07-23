<?php

namespace Src\Horario\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HorarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'medicoId' => $this->medico_id,
            'medico' => $this->whenLoaded('medico', fn() => [
                'id' => $this->medico->id,
                'nombre' => $this->medico->user?->name,
            ]),
            'dia' => $this->dia,
            'horaInicio' => $this->hora_inicio,
            'horaFin' => $this->hora_fin,
            'intervaloMinutos' => $this->intervalo_minutos,
            'activo' => $this->activo,
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
