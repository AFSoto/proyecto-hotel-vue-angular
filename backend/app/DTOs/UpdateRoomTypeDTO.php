<?php

// Define el namespace donde se ubican los DTOs
namespace App\DTOs;

// Clase DTO para actualizar un tipo de habitación
class UpdateRoomTypeDTO
{
    // Constructor con propiedades readonly (inmutables)
    public function __construct(
        // Todas las propiedades son nullable porque en un update pueden no venir
        public readonly ?string $name,
        public readonly ?string $description,
        public readonly ?float  $basePrice,
    ) {}

    // Método estático para crear el DTO desde los datos del request
    public static function fromRequest(array $data): self
    {
        return new self(
            // Si no viene 'name', se asigna null
            name:        $data['name'] ?? null,

            // Si no viene 'description', se asigna null
            description: $data['description'] ?? null,

            // Si viene 'base_price', lo convierte a float, si no, null
            basePrice:   isset($data['base_price']) ? (float) $data['base_price'] : null,
        );
    }

    // Método para convertir el DTO a array (solo con los campos que vienen)
    public function toArray(): array
    {
        // Inicializa un array vacío
        $data = [];

        // Solo agrega 'name' si no es null
        if ($this->name !== null) {
            $data['name'] = $this->name;
        }

        // Solo agrega 'description' si no es null
        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        // Solo agrega 'base_price' si no es null
        if ($this->basePrice !== null) {
            $data['base_price'] = $this->basePrice;
        }

        // Retorna únicamente los campos que se van a actualizar
        return $data;
    }
}
