<?php

namespace Database\Factories;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Village>
 */
class VillageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $aldeas = [
            'San José de la Montaña',
            'Santa Lucía del Valle',
            'El Pino Grande',
            'Nueva Esperanza',
            'San Antonio de las Flores',
            'Villa Los Pájaros',
            'La Unión de las Colinas',
            'El Roble Viejo',
            'La Pradera del Sol',
            'San Pedro de la Cascada',
            'Los Alamos Verdes',
            'Nuevo Horizonte',
            'La Esperanza del Norte',
            'El Bosque Encantado',
            'Pueblo Sereno',
            'El Paraíso de las Aves',
            'Villa Primavera',
            'La Paz de la Montaña',
            'San Miguelito',
            'Bella Vista del Río'
        ];

        return [
            'name' => $this->faker->randomElement($aldeas),
            'sector_id' => Sector::factory(),
            // 'is_active' => $this->faker->boolean(),
            // 'description' => $this->faker->realText(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),

        ];
    }
}
