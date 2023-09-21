<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LocationMapTableWidget;
use Filament\Pages\Page;

class LocationMap extends Page
{
    protected static ?string $navigationIcon = 'ri-road-map-line';

    protected static string $view = 'filament.pages.location-map';

    protected static ?string $modelLabel = 'Localización de mapa';
    protected static ?string $navigationGroup = 'Mapas';

    protected static ?string $pluralModelLabel = 'Localización de mapas';
    protected static ?string $navigationLabel = 'Localización de mapas';


    protected function getHeaderWidgets(): array
    {
        return [
            LocationMapTableWidget::class
        ];
    }

    protected function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }
}
