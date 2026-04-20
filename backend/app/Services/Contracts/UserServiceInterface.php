<?php

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * UserServiceInterface
 *
 * Este contrato define las operaciones relacionadas con la gestión de usuarios.
 *
 * Su propósito es desacoplar la lógica de negocio del controlador,
 * permitiendo:
 * - Cambiar la implementación sin afectar otras capas
 * - Facilitar testing (mockear el servicio)
 * - Mantener una arquitectura limpia (SOLID - DIP)
 */
interface UserServiceInterface
{
    /**
     * Listar usuarios paginados
     *
     * Permite obtener una lista de usuarios con paginación
     * y aplicar filtros opcionales (ej: is_active).
     *
     * @param int $perPage  Cantidad de registros por página (default: 15)
     * @param array $filters Filtros opcionales (ej: ['is_active' => 1])
     *
     * @return LengthAwarePaginator
     */
    public function listUsers(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    /**
     * Crear un nuevo usuario
     *
     * Recibe los datos del usuario (nombre, email, password, rol, etc.)
     * y lo persiste en la base de datos.
     *
     * @param array $data Datos del usuario
     *
     * @return User Usuario creado
     */
    public function createUser(array $data): User;

    /**
     * Buscar un usuario por ID
     *
     * Lanza excepción si no existe.
     *
     * @param int $id ID del usuario
     *
     * @return User Usuario encontrado
     */
    public function findUser(int $id): User;

    /**
     * Actualizar un usuario existente
     *
     * Permite modificar datos como nombre, email o rol.
     * (generalmente no se modifica el password aquí)
     *
     * @param int $id ID del usuario
     * @param array $data Datos a actualizar
     *
     * @return User Usuario actualizado
     */
    public function updateUser(int $id, array $data): User;

    /**
     * Eliminar un usuario
     *
     * Generalmente se usa Soft Delete + desactivación (is_active = false)
     *
     * @param int $id ID del usuario
     *
     * @return bool True si se eliminó correctamente
     */
    public function deleteUser(int $id): bool;
}
