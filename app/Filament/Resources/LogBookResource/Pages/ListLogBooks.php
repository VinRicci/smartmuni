<?php

namespace App\Filament\Resources\LogBookResource\Pages;

use App\Filament\Resources\LogBookResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogBooks extends ListRecords
{
    protected static string $resource = LogBookResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
