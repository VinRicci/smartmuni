<?php

namespace App\Filament\Resources\GeocodeResource\Pages;

use App\Filament\Resources\GeocodeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeocode extends EditRecord
{
    protected static string $resource = GeocodeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make()->label('Ver'),
            Actions\DeleteAction::make()->label('Editar'),
        ];
    }
}
