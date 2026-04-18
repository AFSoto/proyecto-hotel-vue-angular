<?php

namespace App\Repositories\Contracts;

// Modelo específico que se va a usar
use App\Models\User;

/**
 * Interface específica para el repositorio de usuarios
 *
 * Extiende el contrato base (RepositoryInterface)
 * y agrega métodos propios del dominio de usuarios.
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Buscar un usuario por su email
     *
     * @param string $email
     * @return User|null Retorna null si no existe
     */
    public function findByEmail(string $email): ?User;
}
