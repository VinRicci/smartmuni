<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'Servicio';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->description('Cada nuevo servicio debe cumplir con todos los campos.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Servicio activo')
                            ->required(),
                        TextInput::make('cost')
                            ->label('Costo')
                            ->numeric()
                            ->required(),
                        TextInput::make('delay_percentage')
                            ->label('Costo de mora')
                            ->numeric()
                            ->required(),
                        DateTimePicker::make('deadline')
                            ->label('Fecha de corte'),
                        // ...
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('NOMBRE'),
                IconColumn::make('is_active')
                    ->label('ESTADO')
                    ->boolean(),
                TextColumn::make('cost')
                    ->label('COSTO')
                    ->money('GTQ'),
                TextColumn::make('delay_percentage')
                    ->label('MORA')
                    ->money('GTQ'),
                TextColumn::make('deadline')
                    ->label('FECHA DE CORTE')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
