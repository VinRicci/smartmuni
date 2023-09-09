<?php

namespace App\Filament\Resources\ResidenceTypeResource\Pages;

use App\Filament\Resources\ResidenceTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResidenceTypes extends ListRecords
{
    protected static string $resource = ResidenceTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
