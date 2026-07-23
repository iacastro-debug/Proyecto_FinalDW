<?php

namespace Src\HistorialClinico\Domain\Entities;

use DateTimeImmutable;

class HistorialClinico
{
    private string $id;
    private string $citaId;
    private string $pacienteId;
    private string $medicoId;
    private string $motivoConsulta;
    private ?string $observacionesMedicas;
    private string $diagnostico;
    private ?array $medicamentos;
    private ?string $indicaciones;
    private string $fechaAtencion;
    private ?DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $citaId,
        string $pacienteId,
        string $medicoId,
        string $motivoConsulta,
        string $diagnostico,
        ?string $observacionesMedicas = null,
        ?array $medicamentos = null,
        ?string $indicaciones = null,
        string $fechaAtencion = '',
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->citaId = $citaId;
        $this->pacienteId = $pacienteId;
        $this->medicoId = $medicoId;
        $this->motivoConsulta = $motivoConsulta;
        $this->observacionesMedicas = $observacionesMedicas;
        $this->diagnostico = $diagnostico;
        $this->medicamentos = $medicamentos;
        $this->indicaciones = $indicaciones;
        $this->fechaAtencion = $fechaAtencion;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string { return $this->id; }
    public function getCitaId(): string { return $this->citaId; }
    public function getPacienteId(): string { return $this->pacienteId; }
    public function getMedicoId(): string { return $this->medicoId; }
    public function getMotivoConsulta(): string { return $this->motivoConsulta; }
    public function getObservacionesMedicas(): ?string { return $this->observacionesMedicas; }
    public function getDiagnostico(): string { return $this->diagnostico; }
    public function getMedicamentos(): ?array { return $this->medicamentos; }
    public function getIndicaciones(): ?string { return $this->indicaciones; }
    public function getFechaAtencion(): string { return $this->fechaAtencion; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'citaId' => $this->citaId,
            'pacienteId' => $this->pacienteId,
            'medicoId' => $this->medicoId,
            'motivoConsulta' => $this->motivoConsulta,
            'observacionesMedicas' => $this->observacionesMedicas,
            'diagnostico' => $this->diagnostico,
            'medicamentos' => $this->medicamentos,
            'indicaciones' => $this->indicaciones,
            'fechaAtencion' => $this->fechaAtencion,
        ];
    }
}
