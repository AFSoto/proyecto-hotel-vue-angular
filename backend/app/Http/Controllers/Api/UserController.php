<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * UserController
 *
 * Controlador encargado de la gestión de usuarios (CRUD).
 *
 * - Lista usuarios con filtros y paginación
 * - Crea usuarios
 * - Muestra detalle de usuario
 * - Actualiza usuarios
 * - Elimina (soft delete + desactivación)
 *
 * Toda la lógica de negocio se delega al UserService.
 */
class UserController extends BaseController
{
    /**
     * Inyección del servicio de usuarios
     */
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    /**
     * Listar usuarios
     *
     * Soporta:
     * - Filtros (is_active, role_id, search)
     * - Paginación
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // Obtener filtros desde la request
        $filters = $request->only(['is_active', 'role_id', 'search']);

        // Cantidad por página (default 15)
        $perPage = $request->input('per_page', 15);

        // Obtener usuarios paginados desde el servicio
        $users = $this->userService->listUsers($perPage, $filters);

        return response()->json([
            // Transformar colección de usuarios
            'data' => UserResource::collection($users->items()),

            // Información de paginación
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page'    => $users->lastPage(),
                'per_page'     => $users->perPage(),
                'total'        => $users->total(),
            ],

            'message' => 'Listado de usuarios.',
        ]);
    }

    /**
     * Crear usuario
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        // Crear usuario con datos validados
        $user = $this->userService->createUser($request->validated());

        return response()->json([
            // Retornar usuario con rol cargado
            'data'    => new UserResource($user->load('role')),
            'message' => 'Usuario creado exitosamente.',
        ], 201);
    }

    /**
     * Mostrar detalle de un usuario
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        // Obtener usuario o lanzar excepción si no existe
        $user = $this->userService->findUser($id);

        return $this->success(
            new UserResource($user),
            'Detalle del usuario.'
        );
    }

    /**
     * Actualizar usuario
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        // Actualizar usuario con datos validados
        $user = $this->userService->updateUser($id, $request->validated());

        return $this->success(
            new UserResource($user->load('role')),
            'Usuario actualizado exitosamente.'
        );
    }

    /**
     * Eliminar usuario (soft delete + desactivación)
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        // Ejecutar eliminación lógica desde el servicio
        $this->userService->deleteUser($id);

        return $this->success(
            null,
            'Usuario desactivado exitosamente.'
        );
    }
}
