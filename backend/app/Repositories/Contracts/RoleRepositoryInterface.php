<?php

namespace App\Repositories\Contracts;

// Modelo específico de roles
use App\Models\Role;

/**
 * Interface específica para el repositorio de roles
 *
 * Extiende el contrato base (RepositoryInterface)
 * y agrega métodos propios del dominio de roles.
 */
interface RoleRepositoryInterface extends RepositoryInterface
{
    /**
     * Buscar un rol por su slug
     *
     * @param string $slug
     * @return Role|null Retorna null si no existe
     */
    public function findBySlug(string $slug): ?Role;
}
