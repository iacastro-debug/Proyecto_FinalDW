<?php

namespace Src\Notificacion\Domain\Entities;

use DateTimeImmutable;

class Notificacion
{
    private string $id;
    private string $userId;
    private string $titulo;
    private string $mensaje;
    private string $tipo;
    private ?string $referenciaId;
    private bool $leida;
    private ?DateTimeImmutable $createdAt;

    public function __construct(
        string $id,
        string $userId,
        string $titulo,
        string $mensaje,
        string $tipo = 'informacion',
        ?string $referenciaId = null,
        bool $leida = false,
        ?DateTimeImmutable $createdAt = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
        $this->tipo = $tipo;
        $this->referenciaId = $referenciaId;
        $this->leida = $leida;
        $this->createdAt = $createdAt;
    }

    public function getId(): string { return $this->id; }
    public function getUserId(): string { return $this->userId; }
    public function getTitulo(): string { return $this->titulo; }
    public function getMensaje(): string { return $this->mensaje; }
    public function getTipo(): string { return $this->tipo; }
    public function getReferenciaId(): ?string { return $this->referenciaId; }
    public function getLeida(): bool { return $this->leida; }
    public function getCreatedAt(): ?DateTimeImmutable { return $this->createdAt; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'titulo' => $this->titulo,
            'mensaje' => $this->mensaje,
            'tipo' => $this->tipo,
            'referenciaId' => $this->referenciaId,
            'leida' => $this->leida,
            'createdAt' => $this->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
