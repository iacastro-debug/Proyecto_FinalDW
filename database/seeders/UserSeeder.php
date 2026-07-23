<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Auth\Infrastructure\Models\UserEloquentModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        UserEloquentModel::firstOrCreate(
            ['email' => 'admin@medicita.com'],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Administrador',
                'email' => 'admin@medicita.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'activo' => true,
            ]
        );
    }
}
