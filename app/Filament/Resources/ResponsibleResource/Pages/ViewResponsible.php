<?php

namespace App\Filament\Resources\ResponsibleResource\Pages;

use App\Filament\Resources\ResponsibleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewResponsible extends ViewRecord
{
    protected static string $resource = ResponsibleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
