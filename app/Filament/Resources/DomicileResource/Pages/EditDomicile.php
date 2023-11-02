<?php

namespace App\Filament\Resources\DomicileResource\Pages;

use App\Filament\Resources\DomicileResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDomicile extends EditRecord
{
    protected static string $resource = DomicileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
