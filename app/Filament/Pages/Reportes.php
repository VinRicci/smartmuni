<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CientChart;
use App\Filament\Widgets\PSMGraphic;
use App\Filament\Widgets\CMGraphic;

use Filament\Pages\Page;

class Reportes extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reportes';

    protected static ?string $navigationGroup = 'Reportes';

    protected function getHeaderWidgets(): array
    {
        return [
            CientChart::class,
            PSMGraphic::class,
            CMGraphic::class,
        ];
    }
}
