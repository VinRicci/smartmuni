<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Payment;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;


class GraficServ extends ChartWidget
{
    protected static ?string $navigationGroup = 'Censo';

    protected static ?string $heading = 'Grafica de Ingreso';

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
    protected function getType(): string
    {
        return 'line';
    }
}
