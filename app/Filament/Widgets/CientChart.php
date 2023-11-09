<?php

namespace App\Filament\Widgets;

use App\Models\Residence;
use Filament\Widgets\BarChartWidget;

class CientChart extends BarChartWidget
{
    protected static ?string $heading = 'Clientes';

    protected function getData(): array
    {

        return [
            'datasets' => [
                [
                    'label' => 'Numero de recidentes por sector',
                    'data' => Residence::all()->pluck('sector_id')->toArray(),
                    'backgroundColor' => [
                        'rgb(15, 52, 96, 0.8)',
                        'rgb(210, 19, 18, 0.8)',
                        'rgb(69, 25, 82, 0.8)',
                        'rgb(0, 91, 65, 0.8)',
                        'rgb(69, 69, 69, 0.8)',
                        'rgb(0, 129, 112, 0.8)',
                        'rgb(184, 64, 94, 0.8)',
                    ],
                    'borderColor' => [
                        'rgb(15, 52, 96)',
                        'rgb(210, 19, 18)',
                        'rgb(69, 25, 82)',
                        'rgb(0, 91, 65)',
                        'rgb(69, 69, 69)',
                        'rgb(0, 129, 112)',
                        'rgb(184, 64, 94)',
                    ],
                    'borderWidth' => 1
                ],
            ],
            'labels' => Residence::all()->pluck('name')->toArray(),
        ];
    }
}
