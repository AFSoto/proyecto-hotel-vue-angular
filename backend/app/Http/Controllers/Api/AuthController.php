<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * AuthController
 *
 * Controlador encargado de manejar la autenticación:
 * - Login
 * - Obtener usuario autenticado
 * - Logout
 * - Refresh del token
 *
 * Usa AuthServiceInterface para desacoplar la lógica de negocio.
 */
class AuthController extends BaseController
{
    /**
     * Inyección del servicio de autenticación
     *
     * Laravel resuelve automáticamente la implementación
     * gracias al binding en el ServiceProvider.
     */
    public function __construct(
        private AuthServiceInterface $authService
    ) {}

    /**
     * Login de usuario
     *
     * Valida credenciales y retorna token JWT si son correctas.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            // Llamar al servicio de autenticación
            $result = $this->authService->login(
                $request->validated('email'),
                $request->validated('password')
            );

            // Respuesta exitosa con usuario y token
            return response()->json([
                'data'    => new UserResource($result['user']), // Usuario formateado
                'token'   => $result['token'],                  // Token JWT
                'type'    => 'Bearer',                          // Tipo de token
                'expires' => auth('api')->factory()->getTTL() * 60, // Tiempo de expiración en segundos
                'message' => 'Sesión iniciada correctamente.',
            ]);

        } catch (AuthenticationException $e) {
            // Error 401: credenciales incorrectas
            return $this->error($e->getMessage(), 401);

        } catch (AccessDeniedHttpException $e) {
            // Error 403: usuario inactivo o sin acceso
            return $this->error($e->getMessage(), 403);
        }
    }

    /**
     * Obtener usuario autenticado
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        // Obtener usuario desde el servicio
        $user = $this->authService->me();

        // Respuesta estándar usando BaseController
        return $this->success(
            new UserResource($user),
            'Usuario autenticado.'
        );
    }

    /**
     * Cerrar sesión
     *
     * Invalida el token actual
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        // Ejecutar logout en el servicio
        $this->authService->logout();

        return $this->success(
            null,
            'Sesión cerrada correctamente.'
        );
    }

    /**
     * Refrescar token JWT
     *
     * Genera un nuevo token a partir del actual
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        // Obtener nuevo token
        $token = $this->authService->refresh();

        return response()->json([
            'token'   => $token,
            'type'    => 'Bearer',
            'expires' => auth('api')->factory()->getTTL() * 60, // Tiempo de expiración
            'message' => 'Token refrescado correctamente.',
        ]);
    }
}
