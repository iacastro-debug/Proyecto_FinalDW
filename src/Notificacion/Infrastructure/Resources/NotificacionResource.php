<?php

namespace Src\Notificacion\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificacionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'mensaje' => $this->mensaje,
            'tipo' => $this->tipo,
            'referenciaId' => $this->referencia_id,
            'leida' => $this->leida,
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
