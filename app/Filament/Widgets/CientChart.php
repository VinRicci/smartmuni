<?php

namespace App\Filament\Widgets;

use App\Models\Residence;
use Filament\Widgets\BarChartWidget;

class CientChart extends BarChartWidget
{
    protected static ?string $heading = 'Clientes';

    protected function getData(): array
    {
        
        error_log(Residence::all());
        return [
            'datasets' => [
                [
                    'label' => 'Numero de recidentes por sector',
                    'data' => Residence::all()->pluck('sector_id')->toArray(),
                ],
            ],
            'labels' => Residence::all()->pluck('name')->toArray(),
        ];  
    }
}
