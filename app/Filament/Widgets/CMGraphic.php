<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\Payment;
use Carbon\Carbon;

class CMGraphic extends BarChartWidget
{
    protected static ?string $heading = 'Gráfica de Clientes Morosos';
    protected static ?string $navigationGroup = 'Reportes';
    protected static string $color = 'success';

    protected function getData(): array
    {
        // Obtiene todos los pagos con estado 'por pagar'
        $payments = Payment::where('status', 'por pagar')->get();

        // Crea un array para almacenar la cantidad de clientes que no han pagado por mes
        $monthlyData = [];

        foreach ($payments as $payment) {
            $date = Carbon::parse($payment->payment_date);
            $monthName = $date->format('M');

            // Inicializa el valor del mes si no existe en el array.
            if (!isset($monthlyData[$monthName])) {
                $monthlyData[$monthName] = 0;
            }

            // Incrementa la cantidad de clientes que no han pagado en el mes.
            $monthlyData[$monthName]++;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Clientes Morosos por mes',
                    'data' => array_values($monthlyData),
                ],
            ],
            'labels' => array_keys($monthlyData),
        ];
    }

}
