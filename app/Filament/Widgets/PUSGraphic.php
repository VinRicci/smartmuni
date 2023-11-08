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
                        'rgb(15, 52, 96, 0.8)',
                        'rgb(210, 19, 18, 0.8)',
                        'rgb(69, 25, 82, 0.8)',
                        'rgb(0, 91, 65, 0.8)',
                        'rgb(69, 69, 69, 0.8)',
                        'rgb(0, 129, 112, 0.8)',
                        'rgb(184, 64, 94, 0.8)',
                    ],
                ],
            ],
            'labels' => array_map(fn ($data) => $data['label'], $serviceData),
        ];
    }

}
