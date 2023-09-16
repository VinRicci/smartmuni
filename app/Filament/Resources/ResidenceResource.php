<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResidenceResource\Pages;
use App\Filament\Resources\ResidenceResource\RelationManagers;
use App\Models\Residence;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResidenceResource extends Resource
{
    protected static ?string $model = Residence::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->reactive(),
                        // ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        Select::make('residence_type_id')
                            ->required()
                            ->relationship('residence_type', 'name'),

                        Select::make('village_id')
                            ->reactive()
                            ->required()
                            ->relationship('village', 'name')
                            // ->afterStateUpdated(fn ($state, $set) => $set('sector', Sector::query()->pluck('name', 'id') ?? []))
                            ->afterStateUpdated(function ($state, $set) {
                                // \Log::info("estado del select de aldeas " . $state . Sector::query()->where('village_id', $state)->pluck('name', 'id')->toArray());

                                $set('sector_id', Sector::query()->where('village_id', $state)->pluck('name', 'id'));
                            }),

                        Select::make('sector_id')
                            ->required()
                            ->relationship('sector', 'name', fn (Builder $query, $get) => $query->where('village_id', $get('village_id')))
                            // ->options(
                            //     \App\Models\Sector::pluck('name','village_id')
                            // )
                            // ->relationship('sectores'),
                            ->reactive(),
                        // ->relationship('village.sector', 'name')


                        Card::make()
                            ->schema([
                                TextInput::make('responsible.name')
                                    ->required()
                                    ->reactive(),
                                TextInput::make('responsible.dpi')
                                    ->required()
                                    ->reactive(),
                                TextInput::make('responsible.email')
                                    ->required()
                                    ->reactive(),
                                TextInput::make('responsible.phone')
                                    ->required()
                                    ->reactive(),
                                // MarkdownEditor::make('description')
                                //     ->columnSpan('full'),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListResidences::route('/'),
            'create' => Pages\CreateResidence::route('/create'),
            'edit' => Pages\EditResidence::route('/{record}/edit'),
        ];
    }
}
