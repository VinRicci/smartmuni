<?php

namespace App\Filament\Resources\VillageResource\Pages;

use App\Filament\Resources\VillageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVillage extends EditRecord
{
    protected static string $resource = VillageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
