<?php

namespace App\Filament\Resources\ServiceGraphResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Payment;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ServiceGraph extends ChartWidget
{
    //grupo
    protected static ?string $navigationGroup = 'Censo';

    //title
    protected static ?string $modelLabel = 'Grafica de Pagos';

    //title de grafica
    protected static ?string $heading = 'Grafica de Ingreso';

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
    protected function getType(): string
    {
        return 'line';
    }
}
