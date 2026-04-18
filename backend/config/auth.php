<?php

use App\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Valores por defecto de autenticación
    |--------------------------------------------------------------------------
    |
    | Define el "guard" (mecanismo de autenticación) por defecto
    | y el "broker" para recuperación de contraseña.
    |
    */

    'defaults' => [
        // Guard por defecto (web o api)
        'guard' => env('AUTH_GUARD', 'web'),

        // Configuración para reset de contraseñas
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Guards de autenticación
    |--------------------------------------------------------------------------
    |
    | Los guards definen CÓMO se autentican los usuarios.
    |
    | - web → usa sesiones (para apps tradicionales con login y cookies)
    | - api → usa JWT (para APIs sin estado, como tu proyecto)
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session', // Autenticación con sesiones
            'provider' => 'users', // Usa el provider "users"
        ],

        'api' => [
            'driver' => 'jwt',      // Autenticación con JWT (tokens)
            'provider' => 'users',  // Usa el mismo provider de usuarios
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Providers de usuarios
    |--------------------------------------------------------------------------
    |
    | Define cómo Laravel obtiene los usuarios desde la base de datos.
    |
    | Puede ser:
    | - eloquent → usa modelos (recomendado)
    | - database → consultas directas a la BD
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent', // Usa Eloquent (ORM)
            'model' => env('AUTH_MODEL', User::class), // Modelo User
        ],

        // Alternativa sin modelo (no recomendada en tu caso)
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reset de contraseñas
    |--------------------------------------------------------------------------
    |
    | Configuración para recuperación de contraseña:
    | - tabla donde se guardan los tokens
    | - tiempo de expiración del token
    | - tiempo mínimo entre solicitudes (throttle)
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users', // Usa el provider definido arriba

            // Tabla donde se guardan los tokens de recuperación
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),

            // Tiempo de expiración del token (en minutos)
            'expire' => 60,

            // Tiempo de espera entre solicitudes (en segundos)
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tiempo de confirmación de contraseña
    |--------------------------------------------------------------------------
    |
    | Tiempo (en segundos) antes de que Laravel vuelva a pedir
    | la contraseña para acciones sensibles.
    |
    | Ejemplo: eliminar cuenta, cambiar email, etc.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
