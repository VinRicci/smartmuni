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

    protected function getData(): array
    {
        $data = Trend::model(Payment::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        // Crear un array para almacenar los datos clasificados por mes.
        $monthlyData = [];

        foreach ($data as $value) {
            $date = Carbon::parse($value->date);
            $monthName = $date->format('M'); // Obtiene el nombre del mes (ejemplo: "enero")

            // Inicializar el valor del mes si no existe en el array.
            if (!isset($monthlyData[$monthName])) {
                $monthlyData[$monthName] = 0;
            }

            // Agregar el valor agregado al mes correspondiente.
            $monthlyData[$monthName] += $value->aggregate;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos por mes',
                    'data' => array_values($monthlyData),
                    'backgroundColor' => [
                        'rgb(15, 52, 96, 0.2)',
                    ],
                    'borderColor'=> [
                        'rgb(15, 52, 96)',
                    ],
                    'borderWidth'=> '1',
                ],
            ],
            'labels' => array_keys($monthlyData),
        ];
    }

}
