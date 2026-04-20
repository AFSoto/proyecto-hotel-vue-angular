<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * RoomTypeResource
 *
 * Transforma el modelo RoomType a una estructura JSON
 * estandarizada para las respuestas de la API.
 */
class RoomTypeResource extends JsonResource
{
    /**
     * Convertir el recurso a array (respuesta JSON)
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * ID del tipo de habitación
             */
            'id' => $this->id,

            /**
             * Nombre del tipo (Sencilla, Doble, Suite)
             */
            'name' => $this->name,

            /**
             * Descripción del tipo de habitación
             */
            'description' => $this->description,

            /**
             * Precio base
             *
             * Se convierte explícitamente a float
             * para evitar que llegue como string desde el cast decimal
             */
            'base_price' => (float) $this->base_price,

            /**
             * Cantidad de habitaciones asociadas
             *
             * Solo se incluye si previamente se cargó con withCount('rooms')
             * (evita errores si no existe)
             */
            'rooms_count' => $this->when(
                isset($this->rooms_count),
                $this->rooms_count
            ),

            /**
             * Fecha de creación en formato ISO 8601
             * (ideal para frontend)
             */
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
