<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TestSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Limpiar la tabla antes de insertar datos
        Service::truncate();

        // Insertar datos de ejemplo
        Service::create([
            'name' => 'Agua y Alcantarillado',
            'is_active' => true,
            'cost' => 400.00,
            'delay_percentage' => 5,
            'deadline' => '2023-12-31',
            'description' => 'Suministro y gestión del sistema de agua potable y alcantarillado.',
        ]);

        Service::create([
            'name' => 'Gestión de Residuos',
            'is_active' => true,
            'cost' => 200.00,
            'delay_percentage' => 4,
            'deadline' => '2024-12-31',
            'description' => 'Recolección, reciclaje y gestión de residuos sólidos.',
        ]);

        Service::create([
            'name' => 'Licencias Comerciales',
            'is_active' => true,
            'cost' => 100.00,
            'delay_percentage' => 5,
            'deadline' => '2023-12-31',
            'description' => 'Expedición y renovación de licencias comerciales para negocios locales.',
        ]);

        Service::create([
            'name' => 'Asistencia Social',
            'is_active' => true,
            'cost' => 0.00,
            'delay_percentage' => 3,
            'deadline' => '2023-12-31',
            'description' => 'Programas de asistencia social para ayudar a personas necesitadas en la comunidad.',
        ]);

        Service::create([
            'name' => 'Parques y Recreación',
            'is_active' => true,
            'cost' => 50.00,
            'delay_percentage' => 7,
            'deadline' => '2023-12-31',
            'description' => 'Mantenimiento de parques, instalaciones recreativas y programas deportivos.',
        ]);

        Service::create([
            'name' => 'Desarrollo Económico',
            'is_active' => true,
            'cost' => 200.00,
            'delay_percentage' => 10,
            'deadline' => '2023-12-31',
            'description' => 'Apoyo a pequeñas empresas y desarrollo de iniciativas económicas locales.',
        ]);

        Service::create([
            'name' => 'Planificación Urbana',
            'is_active' => true,
            'cost' => 150.00,
            'delay_percentage' => 8,
            'deadline' => '2023-12-31',
            'description' => 'Zonificación, desarrollo de proyectos urbanos y planificación del uso del suelo.',
        ]);
    }
}
