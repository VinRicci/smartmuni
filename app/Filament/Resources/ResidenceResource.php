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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

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
                    ->sortable()
                    ->label('Nombre'),
                TextColumn::make('residence_type.name')
                    ->sortable()
                    ->label('Tipo de residencia'),
                TextColumn::make('village.name')
                    ->sortable()
                    ->label('Aldea'),
                TextColumn::make('sector.name')
                    ->sortable()
                    ->label('Sector'),
                TextColumn::make('location.lat')
                    ->label('Latitud')
                    ->sortable(),
                TextColumn::make('location.lng')
                    ->label('Longitud')
                    ->sortable(),
                TextColumn::make('location.street')

                    ->label('Dirección')
                    ->sortable(),
                TextColumn::make('location.city')
                    ->label('Ciudad')
                    ->sortable()
                    ->searchable(),
                // TextColumn::make('location.state')
                //     ->sortable()
                //     ->searchable(),
                // TextColumn::make('location.zip')
                //     ->sortable(),
                // TextColumn::make('location.formatted_address')
                //     ->label('Dirección')
                //     ->sortable(),
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
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('published_from')
                            ->label(__('accounts/affiliates.table_filter.published_from'))
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                        DatePicker::make('published_until')
                            ->label(__('accounts/affiliates.table_filter.published_until'))
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['published_from'] ?? null) {
                            $indicators['published_from'] = 'Published from ' . Carbon::parse($data['published_from'])->toFormattedDateString();
                        }
                        if ($data['published_until'] ?? null) {
                            $indicators['published_until'] = 'Published until ' . Carbon::parse($data['published_until'])->toFormattedDateString();
                        }
                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
                Tables\Actions\Action::make('logs')
                ->url(fn ($record) => ResidenceResource::getUrl('logs', ['record' => $record]))
                ->label('')
                ->icon('heroicon-o-clock'),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResidences::route('/'),
            'create' => Pages\CreateResidence::route('/create'),
            'edit' => Pages\EditResidence::route('/{record}/edit'),
            'logs' => Pages\LogResidence::route('/{record}/logs'),
        ];
    }
}
