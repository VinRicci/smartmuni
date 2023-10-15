<?php

namespace App\Filament\Resources\GeocodeResource\Pages;

use App\Filament\Resources\GeocodeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGeocode extends ViewRecord
{
    protected static string $resource = GeocodeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()->label('Editar'),
        ];
    }
}
