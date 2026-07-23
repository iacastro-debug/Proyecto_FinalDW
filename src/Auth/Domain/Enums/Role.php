<?php

namespace Src\Auth\Domain\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Recepcionista = 'recepcionista';
    case Medico = 'medico';
    case Paciente = 'paciente';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Recepcionista => 'Recepcionista',
            self::Medico => 'Médico',
            self::Paciente => 'Paciente',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
