<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use App\Models\Geocode;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Actions\StaticMapAction;
use Cheesegrits\FilamentGoogleMaps\Actions\WidgetMapAction;
use Cheesegrits\FilamentGoogleMaps\Helpers\MapsHelper;
use Cheesegrits\FilamentGoogleMaps\Actions\GoToAction;
use Cheesegrits\FilamentGoogleMaps\Fields\WidgetMap;
use Illuminate\Database\Eloquent\Model;
// use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
// use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Filament\Forms;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

//use App\Filament\Resources\LocationResource\RelationManagers;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'gmdi-location-on-o';

    protected static ?string $modelLabel = 'ubicación';
    protected static ?string $navigationGroup = 'Censo';

    protected static ?string $pluralModelLabel = 'ubicaciones';
    protected static ?string $navigationLabel = 'ubicaciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('name')
                //     ->label('Nombre')
                //     ->required()
                //     ->maxLength(256),
                Forms\Components\TextInput::make('lat')
                ->label('Latitud')
                    ->maxLength(32),
                Forms\Components\TextInput::make('lng')
                ->label('longitud')
                    ->maxLength(32),
                Forms\Components\TextInput::make('premise')
                    ->maxLength(255),
                Forms\Components\TextInput::make('street')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip')
                    ->maxLength(255),
                Forms\Components\TextInput::make('formatted_address')
                    // ->default('San Miguel Sigüilá, Guatemala')
                    ->maxLength(1024),
                Forms\Components\Textarea::make('geojson')->required(),
                Forms\Components\Textarea::make('description')->required(),
                Geocomplete::make('location')
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
                    ->prefix('Choose:')
                    ->placeholder('Start typing an address or click Geolocate button ...')
                    ->maxLength(1024)
                    ->geolocate()
                    ->geolocateIcon('heroicon-s-map')
                    ->geocodeOnLoad(),
                Map::make('location')
                    ->debug()
                    // ->zoom(16)
                    ->clickable()
                    // ->layers([
                    //    'https://googlearchive.github.io/js-v2-samples/ggeoxml/cta.kml',
                    // ])
                    ->autocomplete('formatted_address')
                    ->autocompleteReverse()
                    ->reverseGeocode([
                        'city'   => '%L',
                        'zip'    => '%z',
                        'state'  => '%A1',
                        'street' => '%n %S',
                        'premise' => '%p',
                    ])
                    ->drawingControl()
                    ->drawingControlPosition(MapsHelper::POSITION_BOTTOM_CENTER)
                    ->drawingField('geojson')
                    ->drawingModes([
                        'marker'    => true,
                        'circle'    => true,
                        'polygon'   => true,
                        'polyline'  => true,
                        'rectangle' => true,
                    ])
                    // ->geoJson(
                    //     'https://fgm.test/storage/AGEBS01.geojson'
                    // )
                    ->geoJsonVisible(false)
                    ->geoJsonContainsField('geojson', 'CVEGEO')
                    ->geolocate()
                    ->geolocateLabel('Set Location')
                    ->columnSpan(2),

                // WidgetMap::make('widget_map')
                // ->markers(function ($model) {
                //     $markers      = [];
                //     $records      = Location::find(1);
                //     $latLngFields = $model::getLatLngAttributes();

                //     $records->each(function (Model $record) use (&$markers, $latLngFields) {
                //         $latField = $latLngFields['lat'];
                //         $lngField = $latLngFields['lng'];

                //         $markers[] = [
                //             'location' => [
                //                 'lat' => $record->{$latField} ? round(floatval($record->{$latField}), 8) : 0,
                //                 'lng' => $record->{$lngField} ? round(floatval($record->{$lngField}), 8) : 0,
                //             ],
                //         ];
                //     });

                //     return $markers;

                // })
                // ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('name')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('lat'),
                Tables\Columns\TextColumn::make('lng'),
                Tables\Columns\TextColumn::make('street'),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip'),
                Tables\Columns\TextColumn::make('formatted_address'),
                MapColumn::make('location')
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
                MapColumn::make('location'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters(
                [
                    Tables\Filters\TernaryFilter::make('processed')->label("Procesado"),
                    RadiusFilter::make('radius')
                        ->latitude('lat')
                        ->longitude('lng')
                        ->selectUnit()
                        ->section('Radius Search')->label("Busqueda por Radio"),
                ]
            )
            ->filtersLayout(Tables\Filters\Layout::Popover)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                GoToAction::make(),
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

    public static function getWidgets(): array
    {
        return [
            //    LocationResource\Widgets\LocationMapWidget::class,
            //            LocationResource\Widgets\LocationMapTableWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            // 'view'   => Pages\ViewLocation::route('/{record}'),
            'edit'   => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
