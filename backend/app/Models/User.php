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

class User extends Authenticatable
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

    // Campos que NO se devuelven en JSON
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
}
