<?php

namespace App\Repositories;

// Contrato que obliga a implementar estos métodos
use App\Repositories\Contracts\RepositoryInterface;

// Clase base de todos los modelos Eloquent
use Illuminate\Database\Eloquent\Model;

// Colección de resultados (cuando se devuelven múltiples registros)
use Illuminate\Database\Eloquent\Collection;

// Tipo de respuesta cuando se usa paginación
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Clase base abstracta para todos los repositorios
 *
 * Implementa métodos comunes CRUD reutilizables
 * para cualquier modelo que se inyecte.
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * Constructor con inyección del modelo
     *
     * Permite que el repositorio sea reutilizable
     * para cualquier entidad (User, Role, etc.)
     */
    public function __construct(
        protected Model $model
    ) {}

    /**
     * Obtener todos los registros
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Obtener registros paginados
     *
     * @param int $perPage Número de registros por página
     * @param array $filters Filtros opcionales (actualmente no implementados)
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Buscar un registro por ID
     *
     * @param int $id
     * @return Model|null Retorna null si no existe
     */
    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Buscar un registro por ID o lanzar excepción si no existe
     *
     * @param int $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Crear un nuevo registro
     *
     * Usa mass assignment (requiere $fillable en el modelo)
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
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
        // Busca el registro o falla
        $record = $this->findByIdOrFail($id);

        // Actualiza los datos
        $record->update($data);

        // Recarga el modelo desde la BD para devolver datos actualizados
        return $record->fresh();
    }

    /**
     * Eliminar un registro
     *
     * Si el modelo usa SoftDeletes, no se elimina físicamente
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        // Busca el registro o falla
        $record = $this->findByIdOrFail($id);

        // Elimina el registro (soft delete o delete real)
        return $record->delete();
    }
}
