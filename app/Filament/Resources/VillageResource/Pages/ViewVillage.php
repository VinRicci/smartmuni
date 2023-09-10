<?php

namespace App\Filament\Resources\VillageResource\Pages;

use App\Filament\Resources\VillageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVillage extends ViewRecord
{
    protected static string $resource = VillageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
