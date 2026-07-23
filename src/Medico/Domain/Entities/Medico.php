<?php

namespace Src\Medico\Domain\Entities;

use DateTimeImmutable;

class Medico
{
    private string $id;
    private string $userId;
    private string $especialidadId;
    private string $telefono;
    private ?string $numeroRegistro;
    private bool $activo;
    private ?DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $userId,
        string $especialidadId,
        string $telefono,
        ?string $numeroRegistro = null,
        bool $activo = true,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->especialidadId = $especialidadId;
        $this->telefono = $telefono;
        $this->numeroRegistro = $numeroRegistro;
        $this->activo = $activo;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string { return $this->id; }
    public function getUserId(): string { return $this->userId; }
    public function getEspecialidadId(): string { return $this->especialidadId; }
    public function getTelefono(): string { return $this->telefono; }
    public function getNumeroRegistro(): ?string { return $this->numeroRegistro; }
    public function getActivo(): bool { return $this->activo; }
    public function getCreatedAt(): ?DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?DateTimeImmutable { return $this->updatedAt; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'especialidadId' => $this->especialidadId,
            'telefono' => $this->telefono,
            'numeroRegistro' => $this->numeroRegistro,
            'activo' => $this->activo,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
