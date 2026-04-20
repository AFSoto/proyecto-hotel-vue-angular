<?php

// Define el namespace del controlador dentro de la API
namespace App\Http\Controllers\Api;

// Importa los DTOs para transformar los datos del request
use App\DTOs\CreateRoomTypeDTO;
use App\DTOs\UpdateRoomTypeDTO;

// Importa los FormRequest para validación
use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;

// Importa el Resource para formatear la respuesta JSON
use App\Http\Resources\RoomTypeResource;

// Importa la interfaz del servicio (inyección de dependencias)
use App\Services\Contracts\RoomTypeServiceInterface;

// Importa clases necesarias para respuestas HTTP
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Importa excepción para conflictos (reglas de negocio)
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

// Define el controlador que extiende de BaseController
class RoomTypeController extends BaseController
{
    // Constructor con inyección del servicio
    public function __construct(
        private RoomTypeServiceInterface $roomTypeService
    ) {}

    // Método para listar tipos de habitación
    public function index(Request $request): JsonResponse
    {
        // Obtiene filtros (ej: búsqueda)
        $filters = $request->only(['search']);

        // Obtiene cantidad por página (default 15)
        $perPage = $request->input('per_page', 15);

        // Llama al servicio para obtener los datos
        $roomTypes = $this->roomTypeService->listRoomTypes($perPage, $filters);

        // Retorna respuesta JSON estructurada
        return response()->json([
            // Colección transformada con Resource
            'data'    => RoomTypeResource::collection($roomTypes->items()),

            // Información de paginación
            'meta'    => [
                'current_page' => $roomTypes->currentPage(),
                'last_page'    => $roomTypes->lastPage(),
                'per_page'     => $roomTypes->perPage(),
                'total'        => $roomTypes->total(),
            ],

            // Mensaje de respuesta
            'message' => 'Listado de tipos de habitación.',
        ]);
    }

    // Método para crear un nuevo tipo de habitación
    public function store(StoreRoomTypeRequest $request): JsonResponse
    {
        // Convierte los datos validados en un DTO
        $dto = CreateRoomTypeDTO::fromRequest($request->validated());

        // Envía el DTO al servicio
        $roomType = $this->roomTypeService->createRoomType($dto);

        // Retorna respuesta con código 201 (creado)
        return response()->json([
            'data'    => new RoomTypeResource($roomType),
            'message' => 'Tipo de habitación creado exitosamente.',
        ], 201);
    }

    // Método para obtener un tipo de habitación por ID
    public function show(int $id): JsonResponse
    {
        // Busca el recurso usando el servicio
        $roomType = $this->roomTypeService->findRoomType($id);

        // Retorna respuesta usando helper del BaseController
        return $this->success(
            new RoomTypeResource($roomType),
            'Detalle del tipo de habitación.'
        );
    }

    // Método para actualizar un tipo de habitación
    public function update(UpdateRoomTypeRequest $request, int $id): JsonResponse
    {
        // Convierte los datos validados en DTO (solo campos enviados)
        $dto = UpdateRoomTypeDTO::fromRequest($request->validated());

        // Llama al servicio para actualizar
        $roomType = $this->roomTypeService->updateRoomType($id, $dto);

        // Retorna respuesta incluyendo conteo de relaciones
        return $this->success(
            new RoomTypeResource($roomType->loadCount('rooms')),
            'Tipo de habitación actualizado exitosamente.'
        );
    }

    // Método para eliminar un tipo de habitación
    public function destroy(int $id): JsonResponse
    {
        try {
            // Intenta eliminar usando el servicio
            $this->roomTypeService->deleteRoomType($id);

            // Respuesta exitosa sin datos
            return $this->success(
                null,
                'Tipo de habitación eliminado exitosamente.'
            );

        } catch (ConflictHttpException $e) {
            // Captura error de negocio (ej: tiene habitaciones asociadas)
            return $this->error($e->getMessage(), 409);
        }
    }
}
