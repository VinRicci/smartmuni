<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectorResource\Pages;
use App\Filament\Resources\SectorResource\RelationManagers;
use App\Models\Sector;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ActionGroup;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\Filter;


class SectorResource extends Resource
{
    protected static ?string $model = Sector::class;

    protected static ?string $navigationGroup = 'Censo';
    protected static ?string $navigationIcon = 'tabler-home-search';

    protected static ?string $modelLabel = 'Sector';
    protected static ?string $pluralModelLabel = 'Sectores';
    protected static ?string $navigationLabel = 'Sectores';
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
                            ->label('Nombre'),
                        Toggle::make('is_active')->inline(false)
                            ->columnSpan(1)
                            ->label('Activo')
                            ->default(true),
                        Select::make('village_id')
                            ->label('Aldea')
                            ->relationship('village', 'name'),
                        RichEditor::make('description')
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                            ])
                            ->label('Descripción')
                            ->columnSpan(2),
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
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Activo'),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->date(),
                TextColumn::make('village.name')
                    ->label('Aldea'),
                // TextColumn::make('description')
                //     ->label('Descripción')
                //     ->html()
                //     ->words(3),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_active')->label('Estado del sector'),
                // Filter::make('is_active')
                //     ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                // Filter::make('is_active')->toggle()
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                 ])
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
            // RelationManagers\VillagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSectors::route('/'),
            // 'create' => Pages\CreateSector::route('/create'),
            'view' => Pages\ViewSector::route('/{record}'),
            'edit' => Pages\EditSector::route('/{record}/edit'),
        ];
    }
}
