<?php

namespace App\Services\Contracts;

use App\Models\User;

/**
 * AuthServiceInterface
 *
 * Este contrato define las operaciones relacionadas con la autenticación.
 *
 * Su objetivo es desacoplar la lógica de negocio (AuthService)
 * de los controladores, permitiendo:
 * - Cambiar la implementación sin afectar el controller
 * - Facilitar pruebas (mocking)
 * - Mantener una arquitectura limpia (SOLID - DIP)
 */
interface AuthServiceInterface
{
    /**
     * Iniciar sesión de usuario
     *
     * Valida credenciales y genera un token JWT si son correctas.
     *
     * @param string $email    Email del usuario
     * @param string $password Contraseña en texto plano
     *
     * @return array Retorna información del login:
     * [
     *   'user'    => User,
     *   'token'   => string,
     *   'type'    => 'Bearer',
     *   'expires' => int
     * ]
     */
    public function login(string $email, string $password): array;

    /**
     * Cerrar sesión del usuario autenticado
     *
     * Invalida el token JWT actual.
     *
     * @return void
     */
    public function logout(): void;

    /**
     * Obtener usuario autenticado
     *
     * Retorna el usuario asociado al token JWT actual.
     *
     * @return User
     */
    public function me(): User;

    /**
     * Refrescar token JWT
     *
     * Genera un nuevo token a partir del actual (si está dentro del refresh_ttl).
     *
     * @return string Nuevo token JWT
     */
    public function refresh(): string;
}
