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
use Filament\Forms\Components\Group;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResidenceResource extends Resource
{
    protected static ?string $model = Residence::class;

    protected static ?string $modelLabel = 'Censo';
    protected static ?string $navigationGroup = 'Censo';

    protected static ?string $pluralModelLabel = 'Censos';
    protected static ?string $navigationLabel = 'Censos';
    protected static ?string $navigationIcon = 'fluentui-globe-location-24-o';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->reactive(),
                        Select::make('residence_type_id')
                            ->required()
                            ->relationship('residence_type', 'name'),
                        Select::make('village_id')
                            ->reactive()
                            ->required()
                            ->relationship('village', 'name')
                            ->afterStateUpdated(function ($state, $set) {
                                $set('sector_id', Sector::query()->where('village_id', $state)->pluck('name', 'id'));
                            }),
                        Select::make('sector_id')
                            ->required()
                            ->relationship('sector', 'name', fn (Builder $query, $get) => $query->where('village_id', $get('village_id')))
                            ->reactive(),
                        Group::make()
                            ->relationship('responsible')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->reactive(),
                                TextInput::make('dpi')
                                    ->required()
                                    ->reactive(),
                                TextInput::make('email')
                                    ->required()
                                    ->reactive(),
                                TextInput::make('phone')
                                    ->required()
                                    ->reactive(),
                            ]),
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
                TextColumn::make('residence_type.name')
                    ->label('Tipo de residencia'),
                TextColumn::make('village.name')
                    ->label('Aldea'),
                TextColumn::make('sector.name')
                    ->label('Sector'),
                TextColumn::make('location.lat'),
                TextColumn::make('location.lng'),
                TextColumn::make('location.street'),
                TextColumn::make('location.city')
                    ->searchable(),
                TextColumn::make('location.state')
                    ->searchable(),
                TextColumn::make('location.zip'),
                TextColumn::make('location.formatted_address'),
                MapColumn::make('location.location')
                    ->extraAttributes([
                        'class' => 'my-funky-class'
                    ]) // Optionally set any additional attributes, merged into the wrapper div around the image tag
                    ->extraImgAttributes(
                        fn ($record): array => ['title' => $record->latitude . ',' . $record->longitude]
                    ) // Optionally set any additional attributes you want on the img tag
                    ->height('150') // API setting for map height in PX
                    ->width('250') // API setting got map width in PX
                    ->type('hybrid') // API setting for map type (hybrid, satellite, roadmap, tarrain)
                    ->zoom(15) // API setting for zoom (1 through 20)
                    ->ttl(60 * 60 * 24 * 30), // number of seconds to cache image before refetching from API
                MapColumn::make('location.location'),
                TextColumn::make('location.created_at')
                    ->dateTime(),
                TextColumn::make('location.updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            RelationManagers\ServicesRelationManager::class,
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
