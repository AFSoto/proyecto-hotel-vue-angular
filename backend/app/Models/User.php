<?php

namespace App\Models;

// Trait para manejar eliminación lógica (soft delete)
use Illuminate\Database\Eloquent\SoftDeletes;

// Tipo de relación (usuario pertenece a un rol)
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Clase base para autenticación (login, password, etc.)
use Illuminate\Foundation\Auth\User as Authenticatable;

// Permite notificaciones (emails, etc.)
use Illuminate\Notifications\Notifiable;

// Interfaz necesaria para trabajar con JWT
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Modelo User
 *
 * Representa a los usuarios del sistema.
 * Incluye autenticación, relaciones, soft deletes y JWT.
 */
class User extends Authenticatable implements JWTSubject
{
    // Traits usados en el modelo
    use Notifiable, SoftDeletes;

    // Campos que se pueden asignar masivamente (mass assignment)
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
    ];

    /**
     * Campos ocultos en respuestas JSON (API)
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Define conversiones automáticas de tipos
     */
    protected function casts(): array
    {
        return [
            // Hashea automáticamente el password al guardarlo
            'password'  => 'hashed',

            // Convierte 1/0 a true/false
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relación: un usuario pertenece a un rol
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // ─── JWT ────────────────────────────────────────

    /**
     * Retorna el identificador que se almacenará en el token JWT
     *
     * Normalmente es el ID del usuario
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();// equivalente a $this->id
    }

    /**
     * Retorna datos adicionales que se incluirán dentro del token JWT
     *
     * Estos datos se pueden leer en el frontend sin necesidad de otra petición
     */
    public function getJWTCustomClaims(): array
    {
        return [
            // Rol del usuario (ej: admin, receptionist)
            'role' => $this->role->slug,
            // Nombre del usuario
            'name' => $this->name,
        ];
    }
}
