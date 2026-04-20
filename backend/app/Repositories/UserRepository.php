<?php

namespace App\Repositories;

// Modelo específico
use App\Models\User;

// Contrato específico del repositorio de usuarios
use App\Repositories\Contracts\UserRepositoryInterface;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repositorio de usuarios
 *
 * Extiende el BaseRepository para reutilizar el CRUD
 * e implementa métodos específicos del dominio de usuarios.
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Constructor
     *
     * Inyecta el modelo User y lo pasa al BaseRepository
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Obtener usuarios paginados con filtros
     *
     * Permite aplicar filtros dinámicos como:
     * - is_active
     * - role_id
     * - búsqueda por nombre o email
     *
     * @param int $perPage  Cantidad de registros por página
     * @param array $filters Filtros opcionales
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        // Iniciar query incluyendo relación 'role' para evitar N+1
        $query = $this->model->with('role');

        // Filtro por estado activo/inactivo
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        // Filtro por rol
        if (isset($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }

        // Filtro de búsqueda (nombre o email)
        if (isset($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Ordenar por fecha de creación descendente y paginar
        return $query
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Buscar usuario por email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model
            ->where('email', $email)
            ->first();
    }
}
