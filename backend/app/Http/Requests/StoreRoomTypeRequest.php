<?php

// Define el namespace donde está ubicada esta clase dentro del proyecto
namespace App\Http\Requests;

// Importa la clase base FormRequest de Laravel
use Illuminate\Foundation\Http\FormRequest;

// Define la clase StoreRoomTypeRequest que extiende de FormRequest
class StoreRoomTypeRequest extends FormRequest
{
    // Método que determina si el usuario está autorizado para hacer esta petición
    public function authorize(): bool
    {
        // Retorna true, lo que significa que cualquier usuario puede hacer esta solicitud
        return true;
    }

    // Método donde se definen las reglas de validación
    public function rules(): array
    {
        return [
            // Campo 'name'
            // - required: obligatorio
            // - string: debe ser texto
            // - max:80: máximo 80 caracteres
            // - unique:room_types,name: debe ser único en la tabla 'room_types' columna 'name'
            'name'        => ['required', 'string', 'max:80', 'unique:room_types,name'],

            // Campo 'description'
            // - nullable: puede ser nulo
            // - string: debe ser texto si se envía
            'description' => ['nullable', 'string'],

            // Campo 'base_price'
            // - required: obligatorio
            // - numeric: debe ser un número
            // - gt:0: debe ser mayor que 0
            'base_price'  => ['required', 'numeric', 'gt:0'],
        ];
    }

    // Método para personalizar los mensajes de error de validación
    public function messages(): array
    {
        return [
            // Mensaje cuando 'name' es requerido
            'name.required'     => 'El nombre del tipo es obligatorio.',

            // Mensaje cuando 'name' supera los 80 caracteres
            'name.max'          => 'El nombre no puede exceder 80 caracteres.',

            // Mensaje cuando 'name' ya existe en la base de datos
            'name.unique'       => 'Ya existe un tipo de habitación con ese nombre.',

            // Mensaje cuando 'base_price' es requerido
            'base_price.required' => 'El precio base es obligatorio.',

            // Mensaje cuando 'base_price' no es numérico
            'base_price.numeric'  => 'El precio base debe ser un número.',

            // Mensaje cuando 'base_price' no es mayor a 0
            'base_price.gt'       => 'El precio base debe ser mayor a 0.',
        ];
    }
}
