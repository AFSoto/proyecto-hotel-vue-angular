<?php

namespace App\Repositories\Contracts;

/**
 * RoomTypeRepositoryInterface
 *
 * Contrato del repositorio para el modelo RoomType.
 *
 * Extiende RepositoryInterface para heredar
 * las operaciones CRUD básicas (create, update, delete, find, etc.).
 *
 * Aquí se definen métodos específicos del dominio de tipos de habitación.
 */
interface RoomTypeRepositoryInterface extends RepositoryInterface
{
    /**
     * Verificar si un tipo de habitación tiene habitaciones activas asociadas
     *
     * Este método se usa principalmente para validar antes de eliminar
     * un RoomType, evitando romper la integridad del sistema.
     *
     * Ejemplo de uso:
     * - No permitir eliminar un tipo si tiene habitaciones activas
     *
     * @param int $id ID del tipo de habitación
     *
     * @return bool
     * - true  → tiene habitaciones activas
     * - false → no tiene habitaciones activas
     */
    public function hasActiveRooms(int $id): bool;
}
