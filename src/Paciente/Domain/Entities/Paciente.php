<?php

namespace Src\Paciente\Domain\Entities;

use DateTimeImmutable;

class Paciente
{
    private string $id;
    private string $userId;
    private string $tipoDocumento;
    private string $numeroDocumento;
    private string $telefono;
    private ?string $direccion;
    private ?string $fechaNacimiento;
    private ?string $genero;
    private bool $activo;
    private ?DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $userId,
        string $tipoDocumento,
        string $numeroDocumento,
        string $telefono,
        ?string $direccion = null,
        ?string $fechaNacimiento = null,
        ?string $genero = null,
        bool $activo = true,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->tipoDocumento = $tipoDocumento;
        $this->numeroDocumento = $numeroDocumento;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->genero = $genero;
        $this->activo = $activo;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string { return $this->id; }
    public function getUserId(): string { return $this->userId; }
    public function getTipoDocumento(): string { return $this->tipoDocumento; }
    public function getNumeroDocumento(): string { return $this->numeroDocumento; }
    public function getTelefono(): string { return $this->telefono; }
    public function getDireccion(): ?string { return $this->direccion; }
    public function getFechaNacimiento(): ?string { return $this->fechaNacimiento; }
    public function getGenero(): ?string { return $this->genero; }
    public function getActivo(): bool { return $this->activo; }
    public function getCreatedAt(): ?DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?DateTimeImmutable { return $this->updatedAt; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'tipoDocumento' => $this->tipoDocumento,
            'numeroDocumento' => $this->numeroDocumento,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'fechaNacimiento' => $this->fechaNacimiento,
            'genero' => $this->genero,
            'activo' => $this->activo,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
