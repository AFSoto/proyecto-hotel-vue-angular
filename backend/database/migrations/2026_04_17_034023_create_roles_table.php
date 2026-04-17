<?php

// Importa la clase base para crear migraciones en Laravel
use Illuminate\Database\Migrations\Migration;

// Permite definir la estructura de la tabla (columnas, tipos, etc.)
use Illuminate\Database\Schema\Blueprint;

// Permite interactuar con la base de datos (crear, eliminar tablas, etc.)
use Illuminate\Support\Facades\Schema;

// Se define una clase anónima que extiende de Migration
return new class extends Migration
{
    /**
     * Método que se ejecuta al correr:
     * php artisan migrate
     * Aquí se crea la tabla
     */
    public function up(): void
    {
        // Crea la tabla 'roles'
        Schema::create('roles', function (Blueprint $table) {

            // Columna ID autoincremental (PRIMARY KEY)
            $table->id();

            // Nombre del rol (ej: Administrador, Recepcionista)
            // Máximo 50 caracteres
            // unique() evita duplicados
            $table->string('name', 50)->unique();

            // Slug del rol (ej: admin, receptionist)
            // Se usa para lógica interna (middlewares, permisos)
            // También es único
            $table->string('slug', 50)->unique();

            // Crea automáticamente:
            // created_at y updated_at
            $table->timestamps();
        });
    }

    /**
     * Método que se ejecuta al correr:
     * php artisan migrate:rollback
     * Aquí se elimina la tabla
     */
    public function down(): void
    {
        // Elimina la tabla 'roles' si existe
        Schema::dropIfExists('roles');
    }
};
