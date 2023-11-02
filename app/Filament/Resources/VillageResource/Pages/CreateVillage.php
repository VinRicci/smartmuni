<?php

namespace App\Filament\Resources\VillageResource\Pages;

use App\Filament\Resources\VillageResource;
use App\Models\Sector;
use App\Models\Service;
use Filament\Pages\Actions;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class CreateVillage extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;
    protected static string $resource = VillageResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Crear Aldea')
                ->description('')
                ->schema([
                    Card::make()
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label("Nombre")
                                ->columnSpan(1)
                                ->required(),
                            // Select::make('sector')
                            //     ->columnSpan(1)
                            //     ->multiple()
                            //     // ->searchable()
                            //     ->relationship('sector', 'name', fn (Builder $query) => $query->where('is_active', 1))
                            //     ->required()
                            //     ->label('Sector'),
                        ])
                ]),
            Step::make('Agregar servicios')
                ->description('Agregar servicios que va a tener la aldea')
                ->schema([
                    Card::make()
                        ->columnSpan(3)
                        ->schema([
                            CheckboxList::make('services')
                                ->label('Agregar servicios a')
                                ->id('name-field')
                                ->extraAttributes(['class' => 'font-bold text-2xl'])
                                ->columns(2)
                                ->searchable()
                                ->bulkToggleable()
                                ->relationship('services', 'name', fn (Builder $query) => $query->where('is_active', 1))
                        ])
                ]),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
