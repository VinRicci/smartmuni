<?php

namespace App\Filament\Resources\ResponsableResource\Pages;

use App\Filament\Resources\ResponsableResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResponsables extends ListRecords
{
    protected static string $resource = ResponsableResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
