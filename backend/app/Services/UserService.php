<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

/**
 * UserService
 *
 * Implementación de la lógica de negocio para la gestión de usuarios.
 *
 * Este servicio actúa como intermediario entre el controlador
 * y el repositorio, aplicando reglas de negocio antes de acceder a la BD.
 *
 * Extiende BaseService para reutilizar lógica común.
 */
class UserService extends BaseService implements UserServiceInterface
{
    /**
     * Inyección del repositorio de usuarios
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
        // Llamar al constructor del BaseService
        parent::__construct($userRepository);
    }

    /**
     * Listar usuarios con paginación y filtros
     *
     * @param int $perPage  Cantidad de registros por página
     * @param array $filters Filtros opcionales (ej: is_active)
     *
     * @return LengthAwarePaginator
     */
    public function listUsers(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        // Delega al repositorio la consulta paginada
        return $this->userRepository->paginate($perPage, $filters);
    }

    /**
     * Crear un nuevo usuario
     *
     * Aplica reglas de negocio como el hash de la contraseña
     *
     * @param array $data Datos del usuario
     *
     * @return User
     */
    public function createUser(array $data): User
    {
        // Encriptar la contraseña antes de guardar
        $data['password'] = Hash::make($data['password']);

        // Crear usuario en base de datos
        return $this->userRepository->create($data);
    }

    /**
     * Obtener un usuario por ID
     *
     * Lanza excepción si no existe
     * Carga la relación 'role' para evitar consultas adicionales
     *
     * @param int $id
     *
     * @return User
     */
    public function findUser(int $id): User
    {
        return $this->userRepository
            ->findByIdOrFail($id)
            ->load('role');
    }

    /**
     * Actualizar un usuario
     *
     * Permite modificar datos como nombre, email o rol
     *
     * @param int $id
     * @param array $data
     *
     * @return User
     */
    public function updateUser(int $id, array $data): User
    {
        // Delega al repositorio la actualización
        return $this->userRepository->update($id, $data);
    }

    /**
     * Eliminar un usuario (Soft Delete + desactivación)
     *
     * Primero marca el usuario como inactivo
     * luego aplica eliminación lógica (soft delete)
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        // Buscar usuario o lanzar excepción si no existe
        $user = $this->userRepository->findByIdOrFail($id);

        // Marcar como inactivo (regla de negocio)
        $user->update(['is_active' => false]);

        // Eliminar (soft delete)
        return $this->userRepository->delete($id);
    }
}
