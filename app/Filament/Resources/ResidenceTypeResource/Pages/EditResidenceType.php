<?php

namespace App\Filament\Resources\ResidenceTypeResource\Pages;

use App\Filament\Resources\ResidenceTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResidenceType extends EditRecord
{
    protected static string $resource = ResidenceTypeResource::class;

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
