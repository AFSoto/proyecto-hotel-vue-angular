<?php

// Clase base para crear/modificar tablas en la base de datos
use Illuminate\Database\Migrations\Migration;

// Permite definir la estructura de la tabla (columnas)
use Illuminate\Database\Schema\Blueprint;

// Facade para interactuar con el esquema de la base de datos
use Illuminate\Support\Facades\Schema;

/**
 * Migración para la tabla rooms
 *
 * Esta tabla almacenará las habitaciones del sistema,
 * vinculadas a un tipo de habitación (room_types).
 */
return new class extends Migration
{
    /**
     * Ejecutar la migración
     *
     * Aquí se crea la tabla y sus relaciones
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {

            // ID autoincremental (clave primaria)
            $table->id();

            /**
             * Número de la habitación
             * Ej: 101, 202A
             * Debe ser único en todo el sistema
             */
            $table->string('number', 10)->unique();

            /**
             * Piso de la habitación
             * Usa entero pequeño (0–255)
             * Valor por defecto: 1
             */
            $table->unsignedTinyInteger('floor')->default(1);

            /**
             * Relación con room_types
             *
             * foreignId crea la columna room_type_id
             * constrained() define la FK automáticamente
             */
            $table->foreignId('room_type_id')
                ->constrained('room_types') // referencia a tabla room_types
                ->onUpdate('cascade')       // si cambia el id del tipo, se actualiza
                ->onDelete('restrict');     // evita eliminar tipos si hay habitaciones asociadas

            /**
             * Estado de la habitación
             *
             * Valores posibles:
             * - available: disponible
             * - occupied: ocupada
             * - maintenance: en mantenimiento
             */
            $table->enum('status', ['available', 'occupied', 'maintenance'])
                ->default('available');

            /**
             * Notas adicionales (opcional)
             */
            $table->text('notes')->nullable();

            /**
             * Soft Deletes
             *
             * Permite eliminar habitaciones sin borrarlas físicamente
             */
            $table->softDeletes();

            /**
             * Timestamps
             *
             * created_at y updated_at
             */
            $table->timestamps();

            /**
             * Índices para mejorar rendimiento en consultas
             */
            $table->index('room_type_id'); // búsquedas por tipo de habitación
            $table->index('status');       // filtros por estado
            $table->index('floor');        // filtros por piso
        });
    }

    /**
     * Revertir la migración
     *
     * Elimina la tabla si existe
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
