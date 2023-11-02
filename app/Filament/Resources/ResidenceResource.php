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
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Carbon\Carbon;
use Filament\Tables\Actions\ActionGroup;

class ResidenceResource extends Resource
{
    protected static ?string $model = Residence::class;

    protected static ?string $modelLabel = 'Censo';
    protected static ?string $navigationGroup = 'Censo';

    protected static ?string $pluralModelLabel = 'Censos';
    protected static ?string $navigationLabel = 'Censos';
    protected static ?string $navigationIcon = 'fluentui-globe-location-24-o';

    protected static ?int $navigationSort = 1;


    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 5 ? 'success' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->label('Nombre de la vivienda')
                                    ->reactive(),
                                Select::make('residence_type_id')
                                    ->required()
                                    ->label('Tipo de residencia')
                                    ->relationship('residence_type', 'name'),
                                Select::make('village_id')
                                    ->reactive()
                                    ->label('Aldea')
                                    ->required()
                                    ->relationship('village', 'name')
                                    ->afterStateUpdated(function ($state, $set) {
                                        $set('sector_id', Sector::query()->where('village_id', $state)->pluck('name', 'id'));
                                    }),
                                Select::make('sector_id')
                                    ->required()
                                    ->label('Sector')
                                    ->relationship('sector', 'name', fn (Builder $query, $get) => $query->where('village_id', $get('village_id')))
                                    ->reactive(),
                                Group::make()
                                    ->relationship('responsible')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->label('Nombre del responsable')
                                            ->reactive(),
                                        TextInput::make('dpi')
                                            ->required()
                                            ->label('DPI')
                                            ->reactive(),
                                        TextInput::make('email')
                                            ->unique(ignoreRecord: true)
                                            ->required()
                                            ->label('Correo electrónico')
                                            ->reactive(),
                                        TextInput::make('phone')
                                            ->required()
                                            ->label('Número de teléfono')
                                            ->reactive(),
                                    ]),


                            ]),
                    ])->columnSpan(['lg' => fn (?Residence $record) => $record === null ? 3 : 2]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Creado en')
                            ->content(fn (Residence $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Última modificación en')
                            ->content(fn (Residence $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Residence $record) => $record === null)
            ])->columns(3);
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
                    ->sortable(['location.lat'])
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('location.lng')
                    ->label('Longitud')
                    ->sortable(['location.lng'])
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('location.street')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dirección')
                    ->sortable(),
                TextColumn::make('location.city')
                    ->label('Ciudad')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
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
                    ->toggleable(isToggledHiddenByDefault: true)
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
                // ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('location.created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Fecha creada')
                    ->dateTime(),
                TextColumn::make('location.updated_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Fecha modificada')
                    ->dateTime(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('published_from')
                            ->label(__('Publicado desde'))
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                        DatePicker::make('published_until')
                            ->label(__('Publicado hasta'))
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

                SelectFilter::make('residence_type')->relationship('residence_type', 'name')
                    ->label('Filtrar por tipo de residencia'),
                SelectFilter::make('village')->relationship('village', 'name')
                    ->label('Filtrar por aldea'),
                SelectFilter::make('sector')->relationship('sector', 'name')
                    ->label('Filtrar por sector'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()->label('Ver')->tooltip('Ver censo'),
                    Tables\Actions\EditAction::make()->label('Editar')->tooltip('Editar'),
                    Tables\Actions\DeleteAction::make()->label('Eliminar')->tooltip('Eliminar'),
                    Tables\Actions\Action::make('logs')
                        ->color('success')
                        ->url(fn ($record) => ResidenceResource::getUrl('logs', ['record' => $record]))
                        ->label('registros de actividad')
                        ->icon('heroicon-o-clock')
                        ->tooltip('registros de actividad'),
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
            RelationManagers\ServicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResidences::route('/'),
            'create' => Pages\CreateResidence::route('/create'),
            'view'   => Pages\ViewResidence::route('/{record}'),
            'edit' => Pages\EditResidence::route('/{record}/edit'),
            'logs' => Pages\LogResidence::route('/{record}/logs'),
        ];
    }
}
