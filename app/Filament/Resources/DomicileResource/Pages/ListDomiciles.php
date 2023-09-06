<?php

namespace App\Filament\Resources\DomicileResource\Pages;

use App\Filament\Resources\DomicileResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDomiciles extends ListRecords
{
    protected static string $resource = DomicileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
