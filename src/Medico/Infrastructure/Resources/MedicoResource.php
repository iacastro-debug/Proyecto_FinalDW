<?php

namespace Src\Medico\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'especialidadId' => $this->especialidad_id,
            'especialidad' => $this->whenLoaded('especialidad', fn() => [
                'id' => $this->especialidad->id,
                'nombre' => $this->especialidad->nombre,
            ]),
            'user' => $this->whenLoaded('user', fn() => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ]),
            'nombre' => $this->user?->name,
            'email' => $this->user?->email,
            'telefono' => $this->telefono,
            'numeroRegistro' => $this->numero_registro,
            'activo' => $this->activo,
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
