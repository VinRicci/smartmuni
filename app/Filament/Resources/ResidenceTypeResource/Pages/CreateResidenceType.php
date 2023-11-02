<?php

namespace App\Filament\Resources\ResidenceTypeResource\Pages;

use App\Filament\Resources\ResidenceTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResidenceType extends CreateRecord
{
    protected static string $resource = ResidenceTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
