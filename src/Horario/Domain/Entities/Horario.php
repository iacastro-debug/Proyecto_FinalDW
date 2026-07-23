<?php

namespace Src\Horario\Domain\Entities;

use DateTimeImmutable;

class Horario
{
    private string $id;
    private string $medicoId;
    private string $dia;
    private string $horaInicio;
    private string $horaFin;
    private int $intervaloMinutos;
    private bool $activo;
    private ?DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $medicoId,
        string $dia,
        string $horaInicio,
        string $horaFin,
        int $intervaloMinutos = 30,
        bool $activo = true,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->medicoId = $medicoId;
        $this->dia = $dia;
        $this->horaInicio = $horaInicio;
        $this->horaFin = $horaFin;
        $this->intervaloMinutos = $intervaloMinutos;
        $this->activo = $activo;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string { return $this->id; }
    public function getMedicoId(): string { return $this->medicoId; }
    public function getDia(): string { return $this->dia; }
    public function getHoraInicio(): string { return $this->horaInicio; }
    public function getHoraFin(): string { return $this->horaFin; }
    public function getIntervaloMinutos(): int { return $this->intervaloMinutos; }
    public function getActivo(): bool { return $this->activo; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'medicoId' => $this->medicoId,
            'dia' => $this->dia,
            'horaInicio' => $this->horaInicio,
            'horaFin' => $this->horaFin,
            'intervaloMinutos' => $this->intervaloMinutos,
            'activo' => $this->activo,
        ];
    }
}
