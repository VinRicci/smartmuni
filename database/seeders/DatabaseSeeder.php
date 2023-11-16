<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Sector;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Village;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        $this->command->warn(PHP_EOL . 'Creating admin user...');
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Ivan Girón',
            'email' => 'super@super.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Elena Gomez',
            'email' => 'elena.gomez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Luis Rodríguez',
            'email' => 'luis.rodriguez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Ana Martínez',
            'email' => 'ana.martinez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Carlos Hernández',
            'email' => 'carlos.hernandez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Sofia Torres',
            'email' => 'sofia.torres@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Esteban Jiménez',
            'email' => 'andres.gomez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Isabela Rodríguez',
            'email' => 'isabela.rodriguez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Esteban Jiménez',
            'email' => 'esteban.jimenez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Clara Martínez ',
            'email' => 'clara.martinez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Gabriel Díaz ',
            'email' => 'gabriel.diaz@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Carolina Hernández',
            'email' => 'carolina.hernandez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@gmail.com',
        ]));
        $user = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Sofía López',
            'email' => 'sofia.lopez@gmail.com',
        ]));
        $this->command->info('Admin user created.');


        $this->call([
            VillageSeeder::class,
            SectorSeeder::class,
            // TestSeed::class
        ]);


        // $this->command->warn(PHP_EOL . 'Creating sectores...');
        // $brands = $this->withProgressBar(5, fn () => Sector::factory()->count(10)->create());
        // $this->command->info('Sectores created.');

        // $this->command->warn(PHP_EOL . 'Creating aldeas...');
        // $brands = $this->withProgressBar(5, fn () => Village::factory()->count(10)->create());
        // $this->command->info('aldeas created.');




        // $this->call([RolesyPermisos::class]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }


    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection();

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
