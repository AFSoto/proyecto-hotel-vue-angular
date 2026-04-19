<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * AuthService
 *
 * Implementación del servicio de autenticación.
 * Aquí vive la lógica de negocio relacionada con login, logout,
 * usuario autenticado y refresco de token.
 *
 * Se comunica directamente con el guard 'api' (JWT).
 */
class AuthService implements AuthServiceInterface
{
    /**
     * Iniciar sesión
     *
     * @param string $email
     * @param string $password
     *
     * @return array
     * [
     *   'user'  => User,
     *   'token' => string
     * ]
     *
     * @throws AuthenticationException
     * @throws AccessDeniedHttpException
     */
    public function login(string $email, string $password): array
    {
        // Construir credenciales
        $credentials = [
            'email'    => $email,
            'password' => $password,
        ];

        // Intentar autenticar con JWT (retorna token si es válido)
        $token = auth('api')->attempt($credentials);

        // Si falla la autenticación (credenciales incorrectas)
        if (!$token) {
            throw new AuthenticationException('Credenciales incorrectas.');
        }

        // Obtener usuario autenticado
        $user = auth('api')->user();

        // Validar si el usuario está activo
        if (!$user->is_active) {

            // Invalidar token inmediatamente
            auth('api')->logout();

            // Lanzar error 403 (acceso denegado)
            throw new AccessDeniedHttpException(
                'Tu cuenta está desactivada. Contacta al administrador.'
            );
        }

        // Retornar usuario y token
        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Cerrar sesión
     *
     * Invalida el token actual del usuario autenticado
     */
    public function logout(): void
    {
        auth('api')->logout();
    }

    /**
     * Obtener usuario autenticado
     *
     * Retorna el usuario junto con su relación 'role'
     * (evita consultas adicionales en el Resource)
     *
     * @return User
     */
    public function me(): User
    {
        return auth('api')->user()->load('role');
    }

    /**
     * Refrescar token JWT
     *
     * Genera un nuevo token válido a partir del actual
     *
     * @return string
     */
    public function refresh(): string
    {
        return auth('api')->refresh();
    }
}
