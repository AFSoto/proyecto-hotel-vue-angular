<?php

namespace App\Http\Requests;

// Clase base de Laravel para manejar validaciones de formularios
use Illuminate\Foundation\Http\FormRequest;

/**
 * LoginRequest
 *
 * Esta clase se encarga de validar los datos enviados
 * en el request de login (email y password).
 *
 * Se usa directamente en el AuthController para asegurar
 * que los datos sean correctos antes de intentar autenticar.
 */
class LoginRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta petición.
     *
     * En este caso retorna true porque cualquier usuario
     * puede intentar iniciar sesión.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación
     *
     * Define qué campos son obligatorios y su formato.
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required', // El campo es obligatorio
                'string',   // Debe ser tipo string
                'email',    // Debe tener formato válido de email
            ],
            'password' => [
                'required', // El campo es obligatorio
                'string',   // Debe ser tipo string
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
            'email.required'    => 'El email es obligatorio.',
            'email.email'       => 'El formato del email no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ];
    }
}
