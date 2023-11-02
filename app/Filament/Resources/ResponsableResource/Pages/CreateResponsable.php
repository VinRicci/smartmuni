<?php

namespace App\Filament\Resources\ResponsableResource\Pages;

use App\Filament\Resources\ResponsableResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResponsable extends CreateRecord
{
    protected static string $resource = ResponsableResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
