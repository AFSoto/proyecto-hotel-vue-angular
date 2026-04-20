<?php

// Clase base para crear/modificar tablas en la base de datos
use Illuminate\Database\Migrations\Migration;

// Permite definir la estructura de la tabla (columnas)
use Illuminate\Database\Schema\Blueprint;

// Facade para interactuar con el esquema de la base de datos
use Illuminate\Support\Facades\Schema;

/**
 * Migración para la tabla room_types
 *
 * Esta tabla almacenará los tipos de habitaciones del sistema
 * (ej: sencilla, doble, suite, etc.)
 */
return new class extends Migration
{
    /**
     * Ejecutar la migración
     *
     * Aquí se crea la tabla y sus columnas
     */
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {

            // ID autoincremental (clave primaria)
            $table->id();

            // Nombre del tipo de habitación (único)
            // Ej: "Suite", "Doble", "Individual"
            $table->string('name', 80)->unique();

            // Descripción del tipo de habitación (opcional)
            $table->text('description')->nullable();

            // Precio base del tipo de habitación
            // 10 dígitos en total, 2 decimales (ej: 150000.00)
            $table->decimal('base_price', 10, 2);

            /**
             * Soft Deletes
             *
             * Agrega la columna 'deleted_at'
             * Permite eliminar registros de forma lógica (no física)
             */
            $table->softDeletes();

            /**
             * Timestamps
             *
             * Agrega:
             * - created_at
             * - updated_at
             */
            $table->timestamps();
        });
    }

    /**
     * Revertir la migración
     *
     * Elimina la tabla si existe
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
