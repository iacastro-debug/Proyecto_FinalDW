<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Especialidad\Infrastructure\Models\EspecialidadEloquentModel;
use Illuminate\Support\Str;

class EspecialidadSeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = [
            ['nombre' => 'Medicina General', 'descripcion' => 'Atención médica primaria y prevención'],
            ['nombre' => 'Pediatría', 'descripcion' => 'Atención médica para niños y adolescentes'],
            ['nombre' => 'Ginecología', 'descripcion' => 'Salud femenina y reproductiva'],
            ['nombre' => 'Cardiología', 'descripcion' => 'Enfermedades del corazón y sistema circulatorio'],
            ['nombre' => 'Dermatología', 'descripcion' => 'Enfermedades de la piel'],
            ['nombre' => 'Traumatología', 'descripcion' => 'Lesiones del sistema musculoesquelético'],
            ['nombre' => 'Odontología', 'descripcion' => 'Salud bucal y dental'],
            ['nombre' => 'Psicología', 'descripcion' => 'Salud mental y bienestar emocional'],
            ['nombre' => 'Emergencia', 'descripcion' => 'Atención médica de urgencia'],
        ];

        foreach ($especialidades as $esp) {
            EspecialidadEloquentModel::firstOrCreate(
                ['nombre' => $esp['nombre']],
                [
                    'id' => Str::uuid()->toString(),
                    'descripcion' => $esp['descripcion'],
                    'activo' => true,
                ]
            );
        }
    }
}
