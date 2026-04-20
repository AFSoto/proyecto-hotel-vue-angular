<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreUserRequest
 *
 * Esta clase se encarga de validar los datos enviados
 * al momento de crear un usuario.
 *
 * Centraliza las reglas de validación y los mensajes de error,
 * manteniendo el controller limpio (SRP).
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta petición
     *
     * En este caso retorna true porque la autorización
     * se maneja mediante middleware (ej: role:admin)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación
     *
     * Define los campos requeridos y sus restricciones
     */
    public function rules(): array
    {
        return [
            // Nombre del usuario
            'name' => [
                'required', // Obligatorio
                'string',   // Tipo texto
                'max:100',  // Máximo 100 caracteres
            ],

            // Email del usuario
            'email' => [
                'required',             // Obligatorio
                'string',               // Tipo texto
                'email',                // Formato válido de email
                'max:150',              // Máximo 150 caracteres
                'unique:users,email',   // Debe ser único en la tabla users
            ],

            // Contraseña
            'password' => [
                'required',   // Obligatoria
                'string',     // Tipo texto
                'min:8',      // Mínimo 8 caracteres
                'confirmed',  // Debe coincidir con password_confirmation
            ],

            // Rol del usuario
            'role_id' => [
                'required',        // Obligatorio
                'integer',         // Debe ser número entero
                'exists:roles,id', // Debe existir en la tabla roles
            ],
        ];
    }

    /**
     * Mensajes personalizados de error
     *
     * Se devuelven cuando falla la validación
     */
    public function messages(): array
    {
        return [
            'name.required'      => 'El nombre es obligatorio.',
            'name.max'           => 'El nombre no puede exceder 100 caracteres.',

            'email.required'     => 'El email es obligatorio.',
            'email.email'        => 'El formato del email no es válido.',
            'email.unique'       => 'Este email ya está registrado.',

            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',

            'role_id.required'   => 'El rol es obligatorio.',
            'role_id.exists'     => 'El rol seleccionado no existe.',
        ];
    }
}
