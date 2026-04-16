<?php

// Importa la clase Route para definir rutas en Laravel
use Illuminate\Support\Facades\Route;

// ==============================
// 🔓 RUTAS PÚBLICAS (sin token)
// ==============================

// Agrupa rutas bajo el prefijo /api/auth
// Ejemplo: /api/auth/login
Route::prefix('auth')->group(function () {

    // Aquí irá la ruta de login
    // Será algo como:
    // POST /api/auth/login
    // No necesita token porque el usuario aún no está autenticado
});

// ==============================
// 🔐 RUTAS PROTEGIDAS (requieren JWT)
// ==============================

// Este middleware verifica que el usuario tenga un token válido (JWT)
// 'auth:api' significa que usas autenticación tipo API (como JWT)
Route::middleware('auth:api')->group(function () {

    // ------------------------------
    // 🔐 RUTAS DE AUTENTICACIÓN
    // ------------------------------

    // Prefijo /api/auth
    Route::prefix('auth')->group(function () {

        // GET /api/auth/me
        // Devuelve los datos del usuario autenticado

        // POST /api/auth/logout
        // Cierra sesión (invalida el token)

        // POST /api/auth/refresh
        // Genera un nuevo token JWT
    });

    // ------------------------------
    // 👑 SOLO ADMIN
    // ------------------------------

    // Middleware personalizado 'role:admin'
    // Solo usuarios con rol "admin" pueden acceder
    Route::middleware('role:admin')->group(function () {

        // Aquí irán rutas como:
        // usuarios (users)
        // tipos de habitación (room-types)
    });

    // ------------------------------
    // 👥 ADMIN Y RECEPCIONISTA
    // ------------------------------

    // Aquí irán rutas compartidas entre roles


    // Ejemplos:
    // rooms (habitaciones)
    // bookings (reservas)
    // check-ins
    // check-outs
    Route::middleware('role:admin|recepcionista')->group(function () {
    // rutas compartidas
});
});
