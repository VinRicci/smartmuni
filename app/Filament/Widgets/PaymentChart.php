<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\BarChartWidget;

class PaymentChart extends BarChartWidget
{
    protected static ?string $heading = 'Ingresos por sector';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Pagos por sector',
                    'data' => Payment::all()->pluck('amount')->toArray(),
                ],
            ],
            'labels' => Payment::all()->pluck('residence_id')->toArray(),
        ];
    }
}
