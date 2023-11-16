<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;


class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;
    use InteractsWithMaps;


    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
