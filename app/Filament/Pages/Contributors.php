<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Contributors extends Page
{
    protected static ?string $navigationIcon = 'fas-users-gear';
    protected static ?string $modelLabel = 'Contribuidores';
    protected static ?string $navigationGroup = 'Tutoriales';

    protected static ?int $navigationSort     = 2;
    public static function getNavigationLabel(): string
    {
        return __('Contribuidores');
    }
    protected static string $view = 'filament.pages.contributors';
}
