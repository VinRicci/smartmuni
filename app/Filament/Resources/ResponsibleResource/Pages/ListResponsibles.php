<?php

namespace App\Filament\Resources\ResponsibleResource\Pages;

use App\Filament\Resources\ResponsibleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResponsibles extends ListRecords
{
    protected static string $resource = ResponsibleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
