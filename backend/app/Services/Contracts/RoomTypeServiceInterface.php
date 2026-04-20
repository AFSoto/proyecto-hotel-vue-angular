<?php

// Define el namespace donde se ubican los contratos de servicios
namespace App\Services\Contracts;

// Importa los DTOs para creación y actualización
use App\DTOs\CreateRoomTypeDTO;
use App\DTOs\UpdateRoomTypeDTO;

// Importa el modelo RoomType
use App\Models\RoomType;

// Importa el tipo de paginación de Laravel
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * RoomTypeServiceInterface
 *
 * Contrato del servicio para la gestión de tipos de habitación.
 *
 * Define la lógica de negocio que se puede realizar sobre RoomType.
 * Este servicio actúa como intermediario entre el Controller y el Repository.
 */
interface RoomTypeServiceInterface
{
    /**
     * Listar tipos de habitación con paginación y filtros
     *
     * @param int $perPage  Cantidad de registros por página
     * @param array $filters Filtros opcionales (ej: search)
     *
     * @return LengthAwarePaginator
     */
    public function listRoomTypes(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    /**
     * Crear un nuevo tipo de habitación
     *
     * @param array $data Datos validados desde el Request
     *
     * @return RoomType
     */
    public function createRoomType(CreateRoomTypeDTO  $dto): RoomType;

    /**
     * Obtener un tipo de habitación por ID
     *
     * @param int $id
     *
     * @return RoomType
     */
    public function findRoomType(int $id): RoomType;

    /**
     * Actualizar un tipo de habitación
     *
     * @param int $id
     * @param array $data Datos validados
     *
     * @return RoomType
     */
    public function updateRoomType(int $id, UpdateRoomTypeDTO  $dto): RoomType;

    /**
     * Eliminar un tipo de habitación
     *
     * ⚠️ Aquí se aplica lógica de negocio importante:
     * - Validar que no tenga habitaciones activas
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteRoomType(int $id): bool;
}
