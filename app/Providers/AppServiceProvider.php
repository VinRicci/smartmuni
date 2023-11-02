<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Filament\Navigation\NavigationGroup;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {

            Filament::registerViteTheme('resources/css/filament.css');
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Censo'),
                NavigationGroup::make()
                    ->label('Financiero'),
                NavigationGroup::make()
                    ->label('Reportes'),
                NavigationGroup::make()
                    ->label('Administración'),
                NavigationGroup::make()
                    ->label('Gestión de Administrador'),
                    NavigationGroup::make()
                    ->label('HISTORIAL DE AUTENTICACIÓN'),
                NavigationGroup::make()
                    ->label('Tutoriales'),
            ]);
        });

        Filament::registerNavigationGroups([
            'Censo',
            'Financiero',
            'Reportes',
            'Administración',
            'Gestión de Administrador',
            'HISTORIAL DE AUTENTICACIÓN',
            'Tutoriales',
        ]);
    }
}
