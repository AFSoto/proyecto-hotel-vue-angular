<?php

namespace App\Repositories\Contracts;

// Clase base de todos los modelos de Laravel
use Illuminate\Database\Eloquent\Model;

// Colección de resultados (cuando traes muchos registros)
use Illuminate\Database\Eloquent\Collection;

// Paginación (cuando usas paginate)
use Illuminate\Pagination\LengthAwarePaginator;

// Interfaz base para todos los repositorios
interface RepositoryInterface
{
    // Obtener todos los registros
    public function getAll(): Collection;

    // Obtener registros paginados con filtros opcionales
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    // Buscar por ID (puede retornar null si no existe)
    public function findById(int $id): ?Model;

    // Buscar por ID (lanza error si no existe)
    public function findByIdOrFail(int $id): Model;

    // Crear un nuevo registro
    public function create(array $data): Model;

    // Actualizar un registro existente
    public function update(int $id, array $data): Model;

    // Eliminar un registro (soft delete o delete normal)
    public function delete(int $id): bool;
}
