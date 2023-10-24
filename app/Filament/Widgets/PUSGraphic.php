<?php

namespace App\Filament\Widgets;

use Filament\Widgets\DoughnutChartWidget;
use App\Models\Service;

class PUSGraphic extends DoughnutChartWidget
{
    protected static ?string $heading = 'Grafica de Clientes por Servicios';
    protected static ?string $navigationGroup = 'Reportes';

    protected function getData(): array
    {
        $services = Service::all();

        $serviceData = [];

        foreach ($services as $service) {
            $residences = $service->payments->pluck('residence_id')->unique()->count();

            $serviceData[] = [
                'label' => $service->name,
                'residences' => $residences,
            ];
        }

        return [
            'datasets' => [
                [
                    'data' => array_map(fn ($data) => $data['residences'], $serviceData),
                    'backgroundColor' => [
                        'rgb(54, 47, 217, 0.9)',
                        'rgb(255, 176, 0, 0.9)',
                        'rgb(0, 66, 37, 0.9)',
                        'rgb(100, 56, 67, 0.9)',
                        // Agrega más colores si es necesario
                    ],
                ],
            ],
            'labels' => array_map(fn ($data) => $data['label'], $serviceData),
        ];
    }

}
