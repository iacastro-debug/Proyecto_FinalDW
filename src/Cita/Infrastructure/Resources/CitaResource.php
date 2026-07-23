<?php

namespace Src\Cita\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pacienteId' => $this->paciente_id,
            'paciente' => $this->whenLoaded('paciente', fn() => [
                'id' => $this->paciente->id,
                'nombre' => $this->paciente->user?->name,
                'numeroDocumento' => $this->paciente->numero_documento,
            ]),
            'medicoId' => $this->medico_id,
            'medico' => $this->whenLoaded('medico', fn() => [
                'id' => $this->medico->id,
                'nombre' => $this->medico->user?->name,
            ]),
            'especialidadId' => $this->especialidad_id,
            'especialidad' => $this->whenLoaded('especialidad', fn() => [
                'id' => $this->especialidad->id,
                'nombre' => $this->especialidad->nombre,
            ]),
            'fechaCita' => $this->fecha_cita?->format('Y-m-d'),
            'horaCita' => $this->hora_cita,
            'estado' => $this->estado,
            'motivoConsulta' => $this->motivo_consulta,
            'evaluacionIaId' => $this->evaluacion_ia_id,
            'observaciones' => $this->observaciones,
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
