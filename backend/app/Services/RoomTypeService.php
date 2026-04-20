<?php

// Define el namespace del servicio
namespace App\Services;

// Importa los DTOs para creación y actualización
use App\DTOs\CreateRoomTypeDTO;
use App\DTOs\UpdateRoomTypeDTO;

// Importa el modelo RoomType
use App\Models\RoomType;

// Importa el contrato del repositorio
use App\Repositories\Contracts\RoomTypeRepositoryInterface;

// Importa el contrato del servicio
use App\Services\Contracts\RoomTypeServiceInterface;

// Importa la paginación de Laravel
use Illuminate\Pagination\LengthAwarePaginator;

// Importa la excepción HTTP para conflictos
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

/**
 * RoomTypeService
 *
 * Servicio encargado de la lógica de negocio para los tipos de habitación.
 *
 * Actúa como intermediario entre el Controller y el Repository.
 * Aquí se toman decisiones del negocio (no solo acceso a datos).
 */
class RoomTypeService extends BaseService implements RoomTypeServiceInterface
{
    /**
     * Constructor
     *
     * Inyección del repositorio de RoomType
     */
    public function __construct(
        // Se inyecta el repositorio usando su interfaz (desacoplamiento)
        private RoomTypeRepositoryInterface $roomTypeRepository
    ) {
        // Se pasa al BaseService para reutilizar lógica común
        parent::__construct($roomTypeRepository);
    }

    /**
     * Listar tipos de habitación con paginación y filtros
     */
    public function listRoomTypes(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        // Delega al repositorio la obtención de datos paginados
        return $this->roomTypeRepository->paginate($perPage, $filters);
    }

    /**
     * Crear un nuevo tipo de habitación
     */
    public function createRoomType(CreateRoomTypeDTO  $dto): RoomType
    {
        // Convierte el DTO a array y lo envía al repositorio para crear el registro
        return $this->roomTypeRepository->create($dto->toArray());
    }

    /**
     * Obtener un tipo de habitación por ID
     *
     * Incluye el conteo de habitaciones asociadas
     */
    public function findRoomType(int $id): RoomType
    {
        // Busca el registro o lanza error si no existe, luego agrega conteo de 'rooms'
        return $this->roomTypeRepository
            ->findByIdOrFail($id)
            ->loadCount('rooms');
    }

    /**
     * Actualizar un tipo de habitación
     */
    public function updateRoomType(int $id, UpdateRoomTypeDTO  $dto): RoomType
    {
        // Convierte el DTO a array (solo campos enviados) y actualiza el registro
        return $this->roomTypeRepository->update($id, $dto->toArray());
    }

    /**
     * Eliminar un tipo de habitación
     *
     * ⚠️ Lógica de negocio crítica:
     * - No permitir eliminar si tiene habitaciones activas
     */
    public function deleteRoomType(int $id): bool
    {
        // Verifica si existen habitaciones activas asociadas
        if ($this->roomTypeRepository->hasActiveRooms($id)) {

            /**
             * Lanza excepción HTTP 409 (Conflict)
             * indicando que no se puede eliminar por reglas del negocio
             */
            throw new ConflictHttpException(
                'No se puede eliminar este tipo porque tiene habitaciones asociadas.'
            );
        }

        // Si pasa la validación, procede a eliminar (posiblemente soft delete)
        return $this->roomTypeRepository->delete($id);
    }
}
