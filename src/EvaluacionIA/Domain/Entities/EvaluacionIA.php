<?php

namespace Src\EvaluacionIA\Domain\Entities;

use DateTimeImmutable;

class EvaluacionIA
{
    private string $id;
    private string $pacienteId;
    private ?int $edad;
    private ?string $genero;
    private string $sintomasPrincipales;
    private ?string $duracionSintomas;
    private ?string $nivelDolor;
    private bool $fiebre;
    private bool $dificultadRespirar;
    private bool $dolorPeche;
    private ?string $antecedentes;
    private ?string $urgenciaPercibida;
    private ?string $observaciones;
    private ?string $especialidadSugerida;
    private ?string $prioridad;
    private ?string $motivo;
    private string $advertencia;
    private ?string $respuestaRaw;
    private string $estado;
    private bool $modoSimulado;
    private ?DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $pacienteId,
        ?int $edad,
        ?string $genero,
        string $sintomasPrincipales,
        ?string $duracionSintomas = null,
        ?string $nivelDolor = null,
        bool $fiebre = false,
        bool $dificultadRespirar = false,
        bool $dolorPeche = false,
        ?string $antecedentes = null,
        ?string $urgenciaPercibida = null,
        ?string $observaciones = null,
        ?string $especialidadSugerida = null,
        ?string $prioridad = null,
        ?string $motivo = null,
        string $advertencia = '',
        ?string $respuestaRaw = null,
        string $estado = 'generada',
        bool $modoSimulado = false,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->pacienteId = $pacienteId;
        $this->edad = $edad;
        $this->genero = $genero;
        $this->sintomasPrincipales = $sintomasPrincipales;
        $this->duracionSintomas = $duracionSintomas;
        $this->nivelDolor = $nivelDolor;
        $this->fiebre = $fiebre;
        $this->dificultadRespirar = $dificultadRespirar;
        $this->dolorPeche = $dolorPeche;
        $this->antecedentes = $antecedentes;
        $this->urgenciaPercibida = $urgenciaPercibida;
        $this->observaciones = $observaciones;
        $this->especialidadSugerida = $especialidadSugerida;
        $this->prioridad = $prioridad;
        $this->motivo = $motivo;
        $this->advertencia = $advertencia;
        $this->respuestaRaw = $respuestaRaw;
        $this->estado = $estado;
        $this->modoSimulado = $modoSimulado;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string { return $this->id; }
    public function getPacienteId(): string { return $this->pacienteId; }
    public function getEdad(): ?int { return $this->edad; }
    public function getGenero(): ?string { return $this->genero; }
    public function getSintomasPrincipales(): string { return $this->sintomasPrincipales; }
    public function getDuracionSintomas(): ?string { return $this->duracionSintomas; }
    public function getNivelDolor(): ?string { return $this->nivelDolor; }
    public function getFiebre(): bool { return $this->fiebre; }
    public function getDificultadRespirar(): bool { return $this->dificultadRespirar; }
    public function getDolorPeche(): bool { return $this->dolorPeche; }
    public function getAntecedentes(): ?string { return $this->antecedentes; }
    public function getUrgenciaPercibida(): ?string { return $this->urgenciaPercibida; }
    public function getObservaciones(): ?string { return $this->observaciones; }
    public function getEspecialidadSugerida(): ?string { return $this->especialidadSugerida; }
    public function getPrioridad(): ?string { return $this->prioridad; }
    public function getMotivo(): ?string { return $this->motivo; }
    public function getAdvertencia(): string { return $this->advertencia; }
    public function getRespuestaRaw(): ?string { return $this->respuestaRaw; }
    public function getEstado(): string { return $this->estado; }
    public function getModoSimulado(): bool { return $this->modoSimulado; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'pacienteId' => $this->pacienteId,
            'edad' => $this->edad,
            'sintomasPrincipales' => $this->sintomasPrincipales,
            'especialidadSugerida' => $this->especialidadSugerida,
            'prioridad' => $this->prioridad,
            'motivo' => $this->motivo,
            'advertencia' => $this->advertencia,
            'estado' => $this->estado,
            'modoSimulado' => $this->modoSimulado,
        ];
    }
}
