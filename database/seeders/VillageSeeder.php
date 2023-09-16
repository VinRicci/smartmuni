<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Sector;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $aldeasMunicipales = [
            'San Miguel Sigüilá',
            'La Emboscada',
            'El Llano',
            'La Ciénaga',
        ];



        // Inserta los nombres de las aldeas en la base de datos
        foreach ($aldeasMunicipales as $aldea) {
            // $sector_id = Sector::pluck('id')->random(); // Obtiene un ID de sector aleatorio
            DB::table('villages')->insert([
                'name' => $aldea,
                // 'is_active' => $faker->boolean(),
                // 'sector_id' => $sector_id, // Asigna el ID del sector aleatorio
                // 'description' => $faker->realText(),
                'created_at' => $faker->dateTimeBetween('-1 year', '-6 month'),
                'updated_at' => $faker->dateTimeBetween('-5 month', 'now'),
            ]);
        }
    }
}
