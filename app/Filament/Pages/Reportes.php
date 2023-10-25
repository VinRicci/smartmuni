<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CientChart;
use App\Filament\Widgets\PaymentChart;
use App\Filament\Widgets\PSMGraphic;

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
            PaymentChart::class,
        ];
    }
}
