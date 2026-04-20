<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * UpdateUserRequest
 *
 * Esta clase valida los datos enviados al actualizar un usuario.
 *
 * A diferencia de StoreUserRequest:
 * - Usa 'sometimes' porque los campos son opcionales
 * - Permite actualizar parcialmente (PATCH/PUT)
 * - Maneja la validación de email único ignorando el usuario actual
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta petición
     *
     * Se deja en true porque la autorización se maneja
     * mediante middleware (ej: role:admin)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación
     *
     * Usa 'sometimes' para permitir actualizaciones parciales
     */
    public function rules(): array
    {
        // Obtener el ID del usuario desde la ruta (ej: /users/{user})
        $userId = $this->route('user');

        return [
            // Nombre (opcional)
            'name' => [
                'sometimes', // Solo valida si viene en el request
                'string',
                'max:100',
            ],

            // Email (opcional)
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:150',

                /**
                 * Validar que el email sea único,
                 * ignorando el usuario actual
                 */
                Rule::unique('users', 'email')->ignore($userId),
            ],

            // Rol (opcional)
            'role_id' => [
                'sometimes',
                'integer',
                'exists:roles,id', // Debe existir en la tabla roles
            ],
        ];
    }

    /**
     * Mensajes personalizados de error
     */
    public function messages(): array
    {
        return [
            'name.max'       => 'El nombre no puede exceder 100 caracteres.',
            'email.email'    => 'El formato del email no es válido.',
            'email.unique'   => 'Este email ya está registrado.',
            'role_id.exists' => 'El rol seleccionado no existe.',
        ];
    }
}
