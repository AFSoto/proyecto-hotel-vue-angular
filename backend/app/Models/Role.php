<?php

namespace App\Models;

// Clase base de Eloquent (ORM de Laravel)
use Illuminate\Database\Eloquent\Model;

// Tipo de relación (uno a muchos)
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Role
 *
 * Representa los roles del sistema (admin, receptionist, etc.)
 */
class Role extends Model
{
    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'name', // Nombre legible (Ej: Administrador)
        'slug', // Identificador único (Ej: admin)
    ];

    // ─── Relaciones ─────────────────────────────────

    /**
     * Relación: un rol tiene muchos usuarios
     *
     * Ejemplo:
     * - Un rol "admin" puede tener muchos usuarios asignados
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
