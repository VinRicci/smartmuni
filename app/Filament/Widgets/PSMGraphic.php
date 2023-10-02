<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Payment;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;

class PSMGraphic extends LineChartWidget
{
    protected static ?string $heading = 'Grafica de Ingreso';
    protected static ?string $navigationGroup = 'Reportes';
    //protected static ?string $modelLabel = 'Reportes';

    //color
    protected static string $color = 'success';

    protected function getData(): array
    {
        $data = Trend::model(Payment::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Ingresos',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }
    //protected function getType(): string
    //{
    //    return 'line';
    //}
}
