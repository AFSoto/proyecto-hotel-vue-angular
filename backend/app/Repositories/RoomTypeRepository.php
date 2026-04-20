<?php

namespace App\Repositories;

use App\Models\RoomType;
use App\Repositories\Contracts\RoomTypeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * RoomTypeRepository
 *
 * Repositorio encargado de manejar las operaciones de acceso a datos
 * relacionadas con los tipos de habitación.
 *
 * Extiende BaseRepository para reutilizar CRUD básico
 * e implementa métodos específicos del dominio.
 */
class RoomTypeRepository extends BaseRepository implements RoomTypeRepositoryInterface
{
    /**
     * Constructor
     *
     * Inyecta el modelo RoomType y lo pasa al BaseRepository
     *
     * @param RoomType $model
     */
    public function __construct(RoomType $model)
    {
        parent::__construct($model);
    }

    /**
     * Obtener tipos de habitación paginados con filtros
     *
     * Incluye el conteo de habitaciones asociadas (rooms_count)
     *
     * Filtros soportados:
     * - search (por nombre)
     *
     * @param int $perPage
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        // Iniciar query con conteo de habitaciones (evita N+1)
        $query = $this->model->withCount('rooms');

        // Filtro por búsqueda en nombre
        if (isset($filters['search'])) {
            $query->where('name', 'LIKE', "%{$filters['search']}%");
        }

        // Ordenar alfabéticamente y paginar
        return $query
            ->orderBy('name', 'asc')
            ->paginate($perPage);
    }

    /**
     * Verificar si un tipo de habitación tiene habitaciones activas
     *
     * Se usa para evitar eliminar tipos que aún tienen habitaciones asociadas
     *
     * @param int $id
     *
     * @return bool
     */
    public function hasActiveRooms(int $id): bool
    {
        // Obtener el tipo de habitación o lanzar excepción si no existe
        $roomType = $this->findByIdOrFail($id);

        // Verificar si existen habitaciones NO eliminadas (activas)
        return $roomType
            ->rooms()
            ->whereNull('deleted_at') // solo habitaciones activas
            ->exists();
    }
}
