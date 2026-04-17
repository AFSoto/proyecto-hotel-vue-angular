<?php

// Clase base para crear migraciones
use Illuminate\Database\Migrations\Migration;

// Permite definir columnas y estructura de la tabla
use Illuminate\Database\Schema\Blueprint;

// Permite ejecutar acciones sobre la base de datos
use Illuminate\Support\Facades\Schema;

// Clase anónima que representa la migración
return new class extends Migration
{
    /**
     * Se ejecuta al correr:
     * php artisan migrate
     * Aquí se crea la tabla
     */
    public function up(): void
    {
        // Crea la tabla 'users'
        Schema::create('users', function (Blueprint $table) {

            // ID autoincremental (PRIMARY KEY)
            $table->id();

            // Nombre del usuario (máx 100 caracteres)
            $table->string('name', 100);

            // Email único (no permite duplicados)
            $table->string('email', 150)->unique();

            // Contraseña (se almacenará hasheada)
            $table->string('password');

            // Llave foránea hacia la tabla roles
            $table->foreignId('role_id')
                  ->constrained('roles') // referencia a roles.id
                  ->onUpdate('cascade')  // si cambia el id en roles, se actualiza aquí
                  ->onDelete('restrict'); // NO permite eliminar un rol si tiene usuarios

            // Indica si el usuario está activo o no
            // true = activo, false = inactivo
            $table->boolean('is_active')->default(true);

            // Soft delete (elimina lógicamente, no físicamente)
            // crea la columna deleted_at
            $table->softDeletes();

            // Crea created_at y updated_at automáticamente
            $table->timestamps();

            // Índice para mejorar consultas por rol
            $table->index('role_id');

            // Índice para mejorar filtros por estado (activo/inactivo)
            $table->index('is_active');
        });
    }

    /**
     * Se ejecuta al correr:
     * php artisan migrate:rollback
     * Elimina la tabla
     */
    public function down(): void
    {
        // Elimina la tabla 'users' si existe
        Schema::dropIfExists('users');
    }
};
