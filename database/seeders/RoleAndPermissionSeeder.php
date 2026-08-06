<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. PERMISOS POR MÓDULO
        $permissions = [
            // Administrador
            'gestionar usuarios',
            'gestionar roles',
            'gestionar especialidades',
            'gestionar medicos',
            'configurar horarios',
            'consultar reportes',
            'administrar sistema',

            // Recepcionista
            'registrar pacientes',
            'agendar citas recepcion',
            'reprogramar citas recepcion',
            'consultar disponibilidad medicos',
            'confirmar asistencia',

            // Médico
            'consultar citas asignadas',
            'revisar sintomas pacientes',
            'registrar historial clinico',
            'marcar citas atendidas',
            'consultar historial pacientes atendidos',

            // Paciente
            'gestionar datos propios',
            'ingresar sintomas ia',
            'agendar citas paciente',
            'consultar citas propias',
            'consultar historial autorizado',
            'cancelar reprogramar citas propias',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. CREACIÓN DE ROLES Y ASIGNACIÓN DE PERMISOS

        // Administrador: Tiene todos los permisos
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $adminRole->syncPermissions(Permission::all());

        // Recepcionista
        $recepcionRole = Role::firstOrCreate(['name' => 'Recepcionista']);
        $recepcionRole->syncPermissions([
            'registrar pacientes',
            'agendar citas recepcion',
            'reprogramar citas recepcion',
            'consultar disponibilidad medicos',
            'confirmar asistencia',
            'consultar citas asignadas',
        ]);

        // Médico
        $medicoRole = Role::firstOrCreate(['name' => 'Medico']);
        $medicoRole->syncPermissions([
            'consultar citas asignadas',
            'revisar sintomas pacientes',
            'registrar historial clinico',
            'marcar citas atendidas',
            'consultar historial pacientes atendidos',
            'consultar disponibilidad medicos',
        ]);

        // Paciente
        $pacienteRole = Role::firstOrCreate(['name' => 'Paciente']);
        $pacienteRole->syncPermissions([
            'gestionar datos propios',
            'ingresar sintomas ia',
            'agendar citas paciente',
            'consultar citas propias',
            'consultar historial autorizado',
            'cancelar reprogramar citas propias',
        ]);
    }
}