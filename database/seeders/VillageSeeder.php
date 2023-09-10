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
            'San Pedro de la Montaña',
            'Santa Rosa del Valle',
            'El Pino Grande',
            'Nueva Esperanza',
            'San Antonio de las Flores',
            'Villa Los Pájaros',
            'La Unión de las Colinas',
            'El Roble Viejo',
            'La Pradera del Sol',
            'San Miguel de la Cascada',
            'Los Alamos Verdes',
            'Nuevo Horizonte',
            'La Esperanza del Norte',
            'El Bosque Encantado',
            'Pueblo Sereno',
            'El Paraíso de las Aves',
            'Villa Primavera',
            'La Paz de la Montaña',
            'San José de la Colina',
            'Santa Lucía de la Sierra',
            'El Pueblo Nuevo',
            'Las Flores del Río',
            'San Juan de la Vega',
            'Los Cerezos Blancos',
            'Nueva Aurora',
            'La Unión de los Pinos',
            'El Cedro Azul',
            'Villa de la Brisa',
            'El Bosque Encantado',
            'Los Naranjos',
            'San Francisco del Sol',
            'Santa Cruz de la Luna',
            'La Laguna Verde',
            'Los Pájaros del Cielo',
            'El Valle de la Esperanza',
            'Villa de las Flores',
            'El Rincón Tranquilo',
            'Las Palmeras',
            'San Mateo del Sur',
            'San Ignacio de la Sierra',
            'La Colina Dorada',
            'Los Pinos del Norte',
            'El Bosque Encantado',
            'Las Mariposas',
            'El Pueblo Mágico',
            'Villa del Sol Brillante',
            'La Cima de la Montaña',
            'San Lorenzo de la Vega',
            'Santa Isabel de las Aves',
            'El Paraíso Verde'
        ];



        // Inserta los nombres de las aldeas en la base de datos
        foreach ($aldeasMunicipales as $aldea) {
            $sector_id = Sector::pluck('id')->random(); // Obtiene un ID de sector aleatorio
            DB::table('villages')->insert([
                'name' => $aldea,
                // 'is_active' => $faker->boolean(),
                'sector_id' => $sector_id, // Asigna el ID del sector aleatorio
                // 'description' => $faker->realText(),
                'created_at' => $faker->dateTimeBetween('-1 year', '-6 month'),
                'updated_at' => $faker->dateTimeBetween('-5 month', 'now'),
            ]);
        }
    }
}
