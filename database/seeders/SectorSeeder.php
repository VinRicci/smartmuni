<?php

namespace Database\Seeders;

use App\Models\Sector;
use App\Models\Village;
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
            'Los Vásquez',
            'El Centro',
            'El Quetzal',
            'Los Jiménez',
            'Los Gómez Chávez',
            'Los Escobar',
            'Los Chávez',
            'Los Camacho',
            'Los Elías',
            'Los Vicente',
        ];

        // Inserta los nombres de las sectores en la base de datos
        foreach ($sectores as $sector) {
            $village_id = Village::pluck('id')->random();
            DB::table('sectors')->insert([
                'name' => $sector,
                'is_active' => $faker->boolean(),
                'village_id' => $village_id,
                'description' => $faker->realText(),
                'created_at' => $faker->dateTimeBetween('-1 year', '-6 month'),
                'updated_at' => $faker->dateTimeBetween('-5 month', 'now'),
            ]);
        }
    }
}
