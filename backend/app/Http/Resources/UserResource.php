<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * UserResource
 *
 * Esta clase transforma el modelo User en una respuesta JSON estructurada.
 * Se usa para controlar qué datos del usuario se envían al frontend.
 *
 * Evita exponer información sensible (como password)
 * y mantiene una estructura consistente en la API.
 */
class UserResource extends JsonResource
{
    /**
     * Convierte el recurso en un array
     *
     * @param Request $request Petición actual
     * @return array Datos del usuario formateados para la respuesta JSON
     */
    public function toArray(Request $request): array
    {
        return [
            // ID único del usuario
            'id' => $this->id,

            // Nombre del usuario
            'name' => $this->name,

            // Email del usuario
            'email' => $this->email,

            // Estado del usuario (activo/inactivo)
            'is_active' => $this->is_active,

            /**
             * Información del rol asociado
             * Se retorna como un objeto anidado
             */
            'role' => [
                'id'   => $this->role->id,
                'name' => $this->role->name,
                'slug' => $this->role->slug,
            ],

            /**
             * Fecha de creación del usuario
             * Se formatea en estándar ISO 8601 (ideal para frontend)
             */
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
