<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sector>
 */
class SectorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sectores = [
            'La Esperanza',
            'San Juan',
            'Santa Rosa',
            'El Progreso',
            'Nueva Vida',
            'Los Pinos',
            'San Francisco',
            'El Paraíso',
            'La Unión',
            'Santa Lucía',
            'San Pedro',
            'La Fortuna',
            'El Rosario',
            'Bella Vista',
            'San Miguel',
            'La Paz',
            'San Andrés',
            'San José',
            'San Antonio',
            'San Marcos',
        ];

        return [
            'name' => $this->faker->randomElement($sectores),
            'is_active' => $this->faker->boolean(),
            'description' => $this->faker->realText(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
