<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomType;

/**
 * RoomTypeSeeder
 *
 * Seeder encargado de insertar los tipos de habitaciones
 * iniciales en la base de datos.
 *
 * Se usa para tener datos base del sistema (catálogo).
 */
class RoomTypeSeeder extends Seeder
{
    // Evita disparar eventos del modelo (mejora rendimiento en seeders)
    use WithoutModelEvents;

    /**
     * Ejecutar el seeder
     *
     * Inserta tipos de habitaciones si no existen
     */
    public function run(): void
    {
        // Lista de tipos de habitación a crear
        $types = [
            [
                'name'        => 'Sencilla',
                'description' => 'Habitación con cama sencilla, baño privado, TV, Wi-Fi.',
                'base_price'  => 80.00,
            ],
            [
                'name'        => 'Doble',
                'description' => 'Habitación con cama doble o dos camas sencillas, baño privado, TV, Wi-Fi, minibar.',
                'base_price'  => 120.00,
            ],
            [
                'name'        => 'Suite',
                'description' => 'Suite con sala, cama king, baño de lujo, TV, Wi-Fi, minibar, vista panorámica.',
                'base_price'  => 200.00,
            ],
        ];

        /**
         * Recorrer cada tipo de habitación
         */
        foreach ($types as $type) {

            /**
             * firstOrCreate:
             * - Busca un registro por 'name'
             * - Si existe → lo devuelve
             * - Si no existe → lo crea con los datos completos
             *
             * Evita duplicados al ejecutar el seeder varias veces
             */
            RoomType::firstOrCreate(
                ['name' => $type['name']], // condición de búsqueda
                $type                      // datos a insertar si no existe
            );
        }
    }
}
