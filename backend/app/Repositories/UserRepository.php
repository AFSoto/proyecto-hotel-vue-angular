<?php

namespace App\Repositories;

// Modelo específico
use App\Models\User;

// Contrato específico del repositorio de usuarios
use App\Repositories\Contracts\UserRepositoryInterface;

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
