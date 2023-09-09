<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResidenceTypeResource\Pages;
use App\Filament\Resources\ResidenceTypeResource\RelationManagers;
use App\Models\ResidenceType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResidenceTypeResource extends Resource
{
    protected static ?string $model = ResidenceType::class;

    protected static ?string $navigationGroup = 'Censo';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'Tipo de residencia';
    protected static ?string $pluralModelLabel = 'Tipos de residencia';
    protected static ?string $navigationLabel = 'Tipos de residencia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre'),
                Textarea::make('description')
                    ->label('Descripción'),
                Toggle::make('is_active')->inline(false)
                    ->label('Activo')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre'),
                ToggleColumn::make('is_active')
                    ->label('Activo'),
                TextColumn::make('description')
                    ->label('Descripción'),
            ])
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
            'index' => Pages\ListResidenceTypes::route('/'),
            // 'view' => Pages\ViewResidenceType::route('/{record}'),
            // 'create' => Pages\CreateResidenceType::route('/create'),
            // 'edit' => Pages\EditResidenceType::route('/{record}/edit'),
        ];
    }
}
