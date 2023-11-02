<?php

namespace App\Filament\Resources\DomicileResource\Pages;

use App\Filament\Resources\DomicileResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDomicile extends CreateRecord
{
    protected static string $resource = DomicileResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
