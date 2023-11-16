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
use Filament\Forms\Components\Textarea;


class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationGroup = 'Financiero';
    protected static ?string $pluralModelLabel = 'Servicios';
    protected static ?string $navigationLabel = 'Servicios';
    protected static ?string $navigationIcon = 'carbon-service-id';



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
                        Textarea::make('description')
                            ->label('Descripción'),

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
                TextColumn::make('CurrencyAmount')
                    ->label('COSTO'),
                    // ->money('GTQ'),
                TextColumn::make('MoraAmount')
                    ->label('MORA'),
                    // ->money('GTQ'),
                TextColumn::make('deadline')
                    ->label('FECHA DE CORTE')
                    ->date(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'view' => Pages\ViewService::route('/{record}'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
