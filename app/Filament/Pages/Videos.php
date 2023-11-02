<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Videos extends Page
{
    protected static ?string $navigationIcon = 'ri-video-line';

    protected static ?string $modelLabel = 'Video';
    protected static ?string $navigationGroup = 'Tutoriales';
    protected static ?int $navigationSort     = 1;

    protected static string $view = 'filament.pages.videos';
}
