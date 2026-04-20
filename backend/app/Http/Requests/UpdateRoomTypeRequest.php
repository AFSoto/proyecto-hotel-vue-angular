<?php

// Define el namespace donde está ubicada esta clase
namespace App\Http\Requests;

// Importa la clase base FormRequest de Laravel
use Illuminate\Foundation\Http\FormRequest;

// Importa Rule para reglas avanzadas de validación (como unique con condiciones)
use Illuminate\Validation\Rule;

// Define la clase UpdateRoomTypeRequest que extiende de FormRequest
class UpdateRoomTypeRequest extends FormRequest
{
    // Método que define si el usuario está autorizado para hacer esta petición
    public function authorize(): bool
    {
        // Retorna true, cualquier usuario puede hacer esta solicitud
        return true;
    }

    // Método donde se definen las reglas de validación
    public function rules(): array
    {
        // Obtiene el ID del recurso desde la ruta (ej: /room-types/{room_type})
        $roomTypeId = $this->route('room_type');

        return [
            // Campo 'name'
            // - sometimes: solo valida si el campo viene en la petición
            // - string: debe ser texto
            // - max:80: máximo 80 caracteres
            // - unique con ignore: valida que sea único excepto el registro actual
            'name'        => [
                'sometimes',
                'string',
                'max:80',
                Rule::unique('room_types', 'name')->ignore($roomTypeId),
            ],

            // Campo 'description'
            // - sometimes: solo valida si viene en la petición
            // - nullable: puede ser null
            // - string: debe ser texto si se envía
            'description' => ['sometimes', 'nullable', 'string'],

            // Campo 'base_price'
            // - sometimes: solo valida si viene en la petición
            // - numeric: debe ser un número
            // - gt:0: debe ser mayor que 0
            'base_price'  => ['sometimes', 'numeric', 'gt:0'],
        ];
    }

    // Método para personalizar los mensajes de error
    public function messages(): array
    {
        return [
            // Mensaje cuando 'name' supera los 80 caracteres
            'name.max'          => 'El nombre no puede exceder 80 caracteres.',

            // Mensaje cuando 'name' ya existe (excepto el actual)
            'name.unique'       => 'Ya existe un tipo de habitación con ese nombre.',

            // Mensaje cuando 'base_price' no es numérico
            'base_price.numeric'  => 'El precio base debe ser un número.',

            // Mensaje cuando 'base_price' no es mayor a 0
            'base_price.gt'       => 'El precio base debe ser mayor a 0.',
        ];
    }
}
