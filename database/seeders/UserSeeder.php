<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');

        // 1. ADMINISTRADOR
        $admin = User::firstOrCreate(
            ['email' => 'isaac@gmail.com'],
            [
                'name'     => 'Administrador Sistema',
                'password' => Hash::make('bianca2007'), // <--- Encriptada y entre comillas
            ]
        );
        // 2. RECEPCIONISTA
        $recepcionista = User::firstOrCreate(
            ['email' => 'amalia@medicita.com'],
            [
                'name' => 'María Recepción', 
                'password' => Hash::make('amalia2006'),
            ]
        );
        
        // 3. MÉDICO
        $medico = User::firstOrCreate(
            ['email' => 'medico@medicita.com'],
            [
                'name' => 'Dr. Carlos Mendoza', 
                'password' => Hash::make('medico07'),
            ]
        );
       
        // 4. PACIENTE
        $paciente = User::firstOrCreate(
            ['email' => 'paciente@medicita.com'],
            [
                'name' => 'Juan Paciente', 
                'password' => Hash::make('paciente07'),
            ]
        );
        
    }
}