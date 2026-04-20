<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Room
 *
 * Representa una habitación del hotel.
 * Está relacionada con:
 * - RoomType (tipo de habitación)
 * - Booking (reservas)
 */
class Room extends Model
{
    /**
     * SoftDeletes
     *
     * Permite eliminar registros sin borrarlos físicamente
     * usando la columna 'deleted_at'
     */
    use SoftDeletes;

    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'number',        // Número de habitación (ej: 101)
        'floor',         // Piso
        'room_type_id',  // FK hacia room_types
        'status',        // Estado de la habitación
        'notes',         // Notas adicionales
    ];

    /**
     * Casts
     *
     * Convierte tipos automáticamente
     */
    protected function casts(): array
    {
        return [
            'floor' => 'integer', // Asegura que floor sea entero
        ];
    }

    // ─── Relaciones ─────────────────────────────────

    /**
     * Relación: Room pertenece a un RoomType
     *
     * Ej:
     * Room (101) → pertenece a → RoomType (Suite)
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Relación: Room tiene muchas reservas (bookings)
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // ─── Scopes ─────────────────────────────────────

    /**
     * Scope: habitaciones disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope: habitaciones ocupadas
     */
    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    /**
     * Scope: habitaciones en mantenimiento
     */
    public function scopeInMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }
}
