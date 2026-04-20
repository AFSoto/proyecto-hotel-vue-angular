<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo RoomType
 *
 * Representa los tipos de habitaciones en el sistema
 * (ej: Sencilla, Doble, Suite).
 */
class RoomType extends Model
{
    /**
     * Trait SoftDeletes
     *
     * Permite eliminar registros de forma lógica (no física)
     * usando la columna 'deleted_at'
     */
    use SoftDeletes;

    /**
     * Campos asignables masivamente
     *
     * Permite usar create() o update() de forma segura
     */
    protected $fillable = [
        'name',
        'description',
        'base_price',
    ];

    /**
     * Casts de atributos
     *
     * Convierte automáticamente tipos de datos
     */
    protected function casts(): array
    {
        return [
            /**
             * base_price se maneja como decimal con 2 decimales
             * Ej: 150.00
             */
            'base_price' => 'decimal:2',
        ];
    }

    // ─── Relaciones ─────────────────────────────────

    /**
     * Relación: RoomType tiene muchas habitaciones
     *
     * Un tipo de habitación puede tener múltiples rooms
     *
     * Ej:
     * RoomType (Suite) → muchas Rooms (101, 201, 301...)
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
