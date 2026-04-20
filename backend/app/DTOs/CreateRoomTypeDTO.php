<?php

// Define el namespace donde se ubican los DTOs
namespace App\DTOs;

// Clase DTO (Data Transfer Object) para crear un tipo de habitación
class CreateRoomTypeDTO
{
    // Constructor con promoción de propiedades (PHP 8+)
    public function __construct(
        // Propiedad pública, solo lectura (readonly), tipo string
        public readonly string  $name,

        // Propiedad pública, nullable (?string), puede ser null
        public readonly ?string $description,

        // Propiedad pública, tipo float
        public readonly float   $basePrice,
    ) {}

    // Método estático para crear el DTO a partir de un array (por ejemplo, del Request)
    public static function fromRequest(array $data): self
    {
        return new self(
            // Asigna directamente el nombre desde el array
            name:        $data['name'],

            // Si no viene 'description', asigna null
            description: $data['description'] ?? null,

            // Convierte el valor a float antes de asignarlo
            basePrice:   (float) $data['base_price'],
        );
    }

    // Método para convertir el DTO a un array (útil para guardar en base de datos)
    public function toArray(): array
    {
        return [
            // Retorna el nombre
            'name'        => $this->name,

            // Retorna la descripción
            'description' => $this->description,

            // Retorna el precio base con el nombre esperado en la BD
            'base_price'  => $this->basePrice,
        ];
    }
}
