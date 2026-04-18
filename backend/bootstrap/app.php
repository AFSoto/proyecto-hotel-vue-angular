<?php

// Clase principal de Laravel para inicializar la aplicación
use Illuminate\Foundation\Application;

// Manejo de excepciones globales (errores del sistema)
use Illuminate\Foundation\Configuration\Exceptions;

// Configuración de middlewares (filtros de rutas)
use Illuminate\Foundation\Configuration\Middleware;

/**
 * Punto de arranque de la aplicación Laravel (bootstrap)
 *
 * Aquí se configuran:
 * - Rutas (web, api, consola)
 * - Middlewares globales y personalizados
 * - Manejo de excepciones
 */
return Application::configure(basePath: dirname(__DIR__))

    /**
     * Configuración de rutas del sistema
     */
    ->withRouting(
        web: __DIR__ . '/../routes/web.php', // Rutas web (vistas, formularios, etc.)
        api: __DIR__ . '/../routes/api.php', // Rutas API (JSON, usadas por frontend o apps)
        commands: __DIR__ . '/../routes/console.php', // Comandos Artisan personalizados
        health: '/up', // Endpoint de salud (para verificar si la app está activa)
    )

    /**
     * Registro de middlewares
     */
    ->withMiddleware(function (Middleware $middleware) {

        // Alias de middlewares personalizados
        // Permite usar 'role' en las rutas en lugar de escribir la clase completa
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })

    /**
     * Configuración de manejo de excepciones (errores)
     */
    ->withExceptions(function (Exceptions $exceptions): void {
        // Aquí puedes personalizar cómo se manejan los errores globales
        // Ejemplo: logs, respuestas personalizadas, etc.
    })

    // Crea y retorna la instancia final de la aplicación
    ->create();
