<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomType;

/**
 * RoomSeeder
 *
 * Seeder encargado de insertar habitaciones en la base de datos.
 *
 * Depende de RoomTypeSeeder (los tipos deben existir primero).
 */
class RoomSeeder extends Seeder
{
    // Evita disparar eventos del modelo (mejor rendimiento)
    use WithoutModelEvents;

    /**
     * Ejecutar el seeder
     */
    public function run(): void
    {
        /**
         * Obtener los tipos de habitación desde la BD
         * (se asume que ya fueron creados previamente)
         */
        $sencilla = RoomType::where('name', 'Sencilla')->first();
        $doble    = RoomType::where('name', 'Doble')->first();
        $suite    = RoomType::where('name', 'Suite')->first();

        /**
         * Definición de habitaciones
         */
        $rooms = [

            // Piso 1 — 5 habitaciones
            ['number' => '101', 'floor' => 1, 'room_type_id' => $sencilla->id, 'status' => 'available'],
            ['number' => '102', 'floor' => 1, 'room_type_id' => $sencilla->id, 'status' => 'available'],
            ['number' => '103', 'floor' => 1, 'room_type_id' => $doble->id,    'status' => 'available'],
            ['number' => '104', 'floor' => 1, 'room_type_id' => $doble->id,    'status' => 'available'],
            ['number' => '105', 'floor' => 1, 'room_type_id' => $doble->id,    'status' => 'maintenance'],

            // Piso 2 — 5 habitaciones
            ['number' => '201', 'floor' => 2, 'room_type_id' => $sencilla->id, 'status' => 'available'],
            ['number' => '202', 'floor' => 2, 'room_type_id' => $doble->id,    'status' => 'available'],
            ['number' => '203', 'floor' => 2, 'room_type_id' => $doble->id,    'status' => 'available'],
            ['number' => '204', 'floor' => 2, 'room_type_id' => $suite->id,    'status' => 'available'],
            ['number' => '205', 'floor' => 2, 'room_type_id' => $suite->id,    'status' => 'available'],
        ];

        /**
         * Insertar habitaciones evitando duplicados
         */
        foreach ($rooms as $room) {

            /**
             * firstOrCreate:
             * - Busca por número de habitación
             * - Si existe → no crea duplicado
             * - Si no existe → crea el registro
             */
            Room::firstOrCreate(
                ['number' => $room['number']], // condición única
                $room                          // datos a insertar
            );
        }
    }
}
