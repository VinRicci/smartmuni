<?php

namespace App\Filament\Resources\ResidenceResource\Pages;

use App\Filament\Resources\ResidenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResidence extends EditRecord
{
    protected static string $resource = ResidenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
