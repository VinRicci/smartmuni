<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeocodeResource\Pages;
use App\Filament\Resources\GeocodeResource\RelationManagers;
use App\Models\Geocode;
use Cheesegrits\FilamentGoogleMaps\Actions\StaticMapAction;
use Cheesegrits\FilamentGoogleMaps\Actions\WidgetMapAction;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\WidgetMap;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class GeocodeResource extends Resource
{
    protected static ?string $model = Geocode::class;

    protected static ?string $navigationGroup = 'Censo';
    protected static ?string $pluralModelLabel = 'Geocodes';
    protected static ?string $navigationLabel = 'Geocode';

    protected static ?string $navigationIcon = 'tabler-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->label("Nombre")
                    ->maxLength(256),
                Forms\Components\TextInput::make('lat')
                    ->label("Latitud")
                    ->maxLength(32),
                Forms\Components\TextInput::make('lng')
                    ->label("Longitud")
                    ->maxLength(32),
                Forms\Components\TextInput::make('premise')
                    ->label("Premisa")
                    ->maxLength(255),
                Forms\Components\TextInput::make('street')
                    ->label("Calle")
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label("Ciudad")
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->label("Departamento")
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip')
                    ->label("Zip")
                    ->maxLength(255),
                Geocomplete::make('location')
                    ->label("Localización")
                //    ->types(['airport'])
                   ->placeField('name')
                    ->isLocation()
                    ->updateLatLng()
                    ->reverseGeocode([
                        'city'    => '%L',
                        'zip'     => '%z',
                        'state'   => '%A1',
                        'street'  => '%n %S',
                        'premise' => '%p',
                    ])
                    ->prefix('Seleccionar:')
                    ->placeholder('Ingrese la dirección o clik en el botón de Geolocate')
                    ->maxLength(1024)
                    ->geolocate()
                    ->geolocateIcon('heroicon-s-map')
                    ->geocodeOnLoad(),

                WidgetMap::make('widget_map')
                    ->label("Mapa")
                    ->markers(function ($model) {
                        $markers      = [];
                        $records      = Geocode::all();
                        $latLngFields = $model::getLatLngAttributes();

                        $records->each(function (Model $record) use (&$markers, $latLngFields) {
                            $latField = $latLngFields['lat'];
                            $lngField = $latLngFields['lng'];

                            $markers[] = [
                                'location' => [
                                    'lat' => $record->{$latField} ? round(floatval($record->{$latField}), 8) : 0,
                                    'lng' => $record->{$lngField} ? round(floatval($record->{$lngField}), 8) : 0,
                                ],
                            ];
                        });

                        return $markers;

                    })
                    ->columnSpan(2),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Nombre")
                    ->searchable(),

//                Tables\Columns\TextColumn::make('lat'),
//
//                Tables\Columns\TextColumn::make('lng'),

                Tables\Columns\TextColumn::make('street')->label("Calle"),

                Tables\Columns\TextColumn::make('city')->label("Ciudad")
                    ->searchable(),

                Tables\Columns\TextColumn::make('state')->label("Departamento")
                    ->searchable(),

                Tables\Columns\TextColumn::make('zip')->label("Zip"),

//                Tables\Columns\TextColumn::make('formatted_address')
//                    ->wrap()
//                    ->searchable(),

                MapColumn::make('location')->label("Localización"),
            ])
            ->filters([
                    Tables\Filters\TernaryFilter::make('processed')->label("Procesado"),
                    RadiusFilter::make('radius')
                        ->latitude('lat')->label("Latitud")
                        ->longitude('lng')->label("Longitud")
                        ->selectUnit()
                        ->section('Radius Search')->label("Busqueda por Radio"),
                ]
            )
            ->filtersLayout(Tables\Filters\Layout::Popover)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                StaticMapAction::make(),
                WidgetMapAction::make(),
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
            'index'  => Pages\ListGeocodes::route('/'),
            'create' => Pages\CreateGeocode::route('/create'),
            'view'   => Pages\ViewGeocode::route('/{record}'),
            'edit'   => Pages\EditGeocode::route('/{record}/edit'),
        ];
    }
}
