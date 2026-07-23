<?php

namespace Src\Cita\Domain\Entities;

use DateTimeImmutable;

class Cita
{
    private string $id;
    private string $pacienteId;
    private string $medicoId;
    private string $especialidadId;
    private string $fechaCita;
    private string $horaCita;
    private string $estado;
    private ?string $motivoConsulta;
    private ?string $evaluacionIaId;
    private ?string $observaciones;
    private string $createdBy;
    private ?DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $pacienteId,
        string $medicoId,
        string $especialidadId,
        string $fechaCita,
        string $horaCita,
        string $estado = 'pendiente',
        ?string $motivoConsulta = null,
        ?string $evaluacionIaId = null,
        ?string $observaciones = null,
        string $createdBy = '',
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->pacienteId = $pacienteId;
        $this->medicoId = $medicoId;
        $this->especialidadId = $especialidadId;
        $this->fechaCita = $fechaCita;
        $this->horaCita = $horaCita;
        $this->estado = $estado;
        $this->motivoConsulta = $motivoConsulta;
        $this->evaluacionIaId = $evaluacionIaId;
        $this->observaciones = $observaciones;
        $this->createdBy = $createdBy;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string { return $this->id; }
    public function getPacienteId(): string { return $this->pacienteId; }
    public function getMedicoId(): string { return $this->medicoId; }
    public function getEspecialidadId(): string { return $this->especialidadId; }
    public function getFechaCita(): string { return $this->fechaCita; }
    public function getHoraCita(): string { return $this->horaCita; }
    public function getEstado(): string { return $this->estado; }
    public function getMotivoConsulta(): ?string { return $this->motivoConsulta; }
    public function getEvaluacionIaId(): ?string { return $this->evaluacionIaId; }
    public function getObservaciones(): ?string { return $this->observaciones; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'pacienteId' => $this->pacienteId,
            'medicoId' => $this->medicoId,
            'especialidadId' => $this->especialidadId,
            'fechaCita' => $this->fechaCita,
            'horaCita' => $this->horaCita,
            'estado' => $this->estado,
            'motivoConsulta' => $this->motivoConsulta,
            'evaluacionIaId' => $this->evaluacionIaId,
            'observaciones' => $this->observaciones,
        ];
    }
}
