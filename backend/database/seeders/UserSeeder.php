<?php

namespace Database\Seeders;

// Desactiva eventos de modelo durante el seeding
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// Clase base de seeders
use Illuminate\Database\Seeder;

// Modelos
use App\Models\User;
use App\Models\Role;

// Para encriptar contraseñas
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // Evita eventos como created, updated, etc.
    use WithoutModelEvents;

    public function run(): void
    {
        // Busca el rol admin en la base de datos
        $adminRole = Role::where('slug', 'admin')->first();

        // Busca el rol recepcionista
        $receptionistRole = Role::where('slug', 'receptionist')->first();

        // Lista de usuarios a crear
        $users = [
            [
                'name'      => 'Admin Hotel',
                'email'     => 'admin@hotel.com',
                'password'  => 'password',
                'role_id'   => $adminRole->id,         // relación con rol admin
                'is_active' => true,
            ],
            [
                'name'      => 'María Recepción',
                'email'     => 'recep@hotel.com',
                'password'  => 'password',
                'role_id'   => $receptionistRole->id,
                'is_active' => true,
            ],
        ];

        // Inserta usuarios evitando duplicados por email
        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name'      => $user['name'],
                    'role_id'   => $user['role_id'],
                    'is_active' => $user['is_active'],
                    'password'  => $user['password'],
                ]
            );
        }
    }
}
