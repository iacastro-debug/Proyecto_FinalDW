<?php

namespace Src\Paciente\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacienteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'user' => $this->whenLoaded('user', fn() => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ]),
            'nombre' => $this->user?->name,
            'email' => $this->user?->email,
            'tipoDocumento' => $this->tipo_documento,
            'numeroDocumento' => $this->numero_documento,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'fechaNacimiento' => $this->fecha_nacimiento?->format('Y-m-d'),
            'genero' => $this->genero,
            'activo' => $this->activo,
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
