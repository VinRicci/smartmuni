<?php

namespace App\Filament\Resources\ResidenceResource\Pages;

use App\Filament\Resources\ResidenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;


class EditResidence extends EditRecord
{
    protected static string $resource = ResidenceResource::class;
    use InteractsWithMaps;

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
