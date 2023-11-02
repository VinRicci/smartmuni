<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Support\Facades\Auth;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $service = $this->record;
        $nombreUsuario = Auth::user()->name;

        Notification::make()
            ->title('Nuevo servicio creado')
            ->icon('gmdi-miscellaneous-services-o')
            ->body("Servicio creado por " . "**{$nombreUsuario}**")
            ->actions([
                Action::make('View')
                    ->label('Ver servicio')
                    ->url(ServiceResource::getUrl('view', ['record' => $service])),
            ])
            ->sendToDatabase(auth()->user());
    }
}
