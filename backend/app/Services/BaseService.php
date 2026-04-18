<?php

namespace App\Services;

// Contrato del repositorio (inyección por interfaz → desacoplamiento)
use App\Repositories\Contracts\RepositoryInterface;

// Tipo base de modelo Eloquent
use Illuminate\Database\Eloquent\Model;

// Colección de resultados
use Illuminate\Database\Eloquent\Collection;

// Paginación
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Clase base para la capa de servicios
 *
 * Encapsula la lógica de negocio y actúa como intermediario
 * entre los Controllers y los Repositories.
 */
abstract class BaseService
{
    /**
     * Inyección del repositorio
     *
     * Permite trabajar con cualquier repositorio que implemente
     * RepositoryInterface (UserRepository, RoleRepository, etc.)
     */
    public function __construct(
        protected RepositoryInterface $repository
    ) {}

    /**
     * Obtener todos los registros
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Obtener registros paginados con filtros
     *
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $filters);
    }

    /**
     * Buscar por ID (puede retornar null)
     *
     * @param int $id
     * @return Model|null
     */
    public function findById(int $id): ?Model
    {
        return $this->repository->findById($id);
    }

    /**
     * Buscar por ID o lanzar excepción si no existe
     *
     * @param int $id
     * @return Model
     */
    public function findByIdOrFail(int $id): Model
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Crear un nuevo registro
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Actualizar un registro existente
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Eliminar un registro
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
