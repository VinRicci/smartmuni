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
            'Sector 1: Los Vásquez',
            'Sector 2: El Centro',
            'Sector 3: El Quetzal',
            'Sector 1: Los Jiménez',
            'Sector 2: Los Gómez Chávez',
            'Sector 3: Los Escobar',
            'Sector 4: Los Chávez',
            'Sector 5: Los Camacho',
            'Sector 6: Los Elías',
            'Los Vicente',
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
