<?php

namespace Database\Seeders;

// Trait para evitar que se ejecuten eventos de modelo durante el seeding
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// Clase base de seeders
use Illuminate\Database\Seeder;

// Modelo Role para insertar datos en la tabla roles
use App\Models\Role;

// Seeder encargado de poblar la tabla roles
class RoleSeeder extends Seeder
{
    // Desactiva eventos como created, updated, etc.
    use WithoutModelEvents;

    /**
     * Método principal que se ejecuta con:
     * php artisan db:seed
     */
    public function run(): void
    {
        // Lista de roles a insertar
        $roles = [
            [
                'name' => 'Administrador', // Nombre visible
                'slug' => 'admin',         // Identificador lógico (para permisos)
            ],
            [
                'name' => 'Recepcionista',
                'slug' => 'receptionist',
            ],
        ];

        // Recorre cada rol
        foreach ($roles as $role) {

            // Busca por slug:
            // - Si existe → no lo duplica
            // - Si no existe → lo crea
            Role::firstOrCreate(
                ['slug' => $role['slug']], // condición
                $role                      // datos
            );
        }
    }
}
