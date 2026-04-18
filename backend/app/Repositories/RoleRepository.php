<?php

namespace App\Repositories;

// Modelo Role
use App\Models\Role;

// Contrato específico del repositorio de roles
use App\Repositories\Contracts\RoleRepositoryInterface;

/**
 * Repositorio de roles
 *
 * Extiende el BaseRepository para reutilizar el CRUD
 * y agrega métodos específicos del dominio de roles.
 */
class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * Constructor
     *
     * Inyecta el modelo Role y lo pasa al BaseRepository
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Buscar un rol por su slug
     *
     * Ejemplo de slug:
     * - admin
     * - receptionist
     *
     * @param string $slug
     * @return Role|null
     */
    public function findBySlug(string $slug): ?Role
    {
        return $this->model
            ->where('slug', $slug)
            ->first();
    }
}
