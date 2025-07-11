<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SecretariaAcademica;
use Illuminate\Support\Facades\Hash;

class SecretariaSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario de secretaría
        $user = User::create([
            'name' => 'Secretaria Test',
            'email' => 'secretaria@test.com',
            'password' => Hash::make('12345678'),
            'rol' => 'secretaria_academica',
            'email_verified_at' => now()
        ]);

        // Crear registro de secretaría académica
        SecretariaAcademica::create([
            'user_id' => $user->id,
            'apellido' => 'Academica',
            'cif' => 'SEC001'
        ]);

        $this->command->info('Usuario de secretaría creado: secretaria@test.com - Contraseña: 12345678');
    }
} 