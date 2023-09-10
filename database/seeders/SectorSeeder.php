<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

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

        // Inserta los nombres de las sectores en la base de datos
        foreach ($sectores as $sector) {
            DB::table('sectors')->insert([
                'name' => $sector,
                'is_active' => $faker->boolean(),
                'description' => $faker->realText(),
                'created_at' => $faker->dateTimeBetween('-1 year', '-6 month'),
                'updated_at' => $faker->dateTimeBetween('-5 month', 'now'),
            ]);
        }
    }
}
