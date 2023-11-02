<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VillageResource\Pages;
use App\Filament\Resources\VillageResource\RelationManagers;
use App\Models\Village;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VillageResource extends Resource
{
    protected static ?string $model = Village::class;

    protected static ?string $navigationGroup = 'Censo';
    protected static ?string $navigationIcon = 'gmdi-holiday-village-o';

    protected static ?string $modelLabel = 'Aldea';
    protected static ?string $pluralModelLabel = 'Aldeas';
    protected static ?string $navigationLabel = 'Aldeas';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->columnSpan(1)
                            ->label('Nombre')
                            ->required(),
                        // Select::make('sectors')
                        //     ->columnSpan(1)
                        //     ->searchable()
                        //     ->multiple()
                        //     ->relationship('sectors', 'name')
                        //     ->required()
                        //     ->label('Sector'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nombre'),
                // TextColumn::make('sector.name')
                //     ->searchable()
                //     ->label('Sector'),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->date(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make()->exports([
                    ExcelExport::make('Exportar tabla')->fromTable(),
                    ExcelExport::make('Exportar modelo')->fromForm(),
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ServicesRelationManager::class,
            RelationManagers\SectorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVillages::route('/'),
            'create' => Pages\CreateVillage::route('/create'),
            'view' => Pages\ViewVillage::route('/{record}'),
            'edit' => Pages\EditVillage::route('/{record}/edit'),
        ];
    }
}
