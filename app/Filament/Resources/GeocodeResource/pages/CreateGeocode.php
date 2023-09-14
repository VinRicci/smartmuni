<?php

namespace App\Filament\Resources\GeocodeResource\Pages;

use App\Filament\Resources\GeocodeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGeocode extends CreateRecord
{
    protected static string $resource = GeocodeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
