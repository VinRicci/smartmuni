<?php

namespace App\Filament\Resources\ResidenceResource\Pages;

use App\Filament\Resources\ResidenceResource;
use App\Models\Sector;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;

use App\Models\Location;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Actions\StaticMapAction;
use Cheesegrits\FilamentGoogleMaps\Actions\WidgetMapAction;
use Cheesegrits\FilamentGoogleMaps\Helpers\MapsHelper;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Actions\GoToAction;

use Closure;

class CreateResidence extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = ResidenceResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Datos de la vivienda')
                ->description('Give the category a clear and unique name')
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
                                ->reactive()
                            // ->relationship('village.sector', 'name')
                        ])

                ]),
            Step::make('Responsable')
                ->description('Datos del responsable')
                ->schema([
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

                ]),
            Step::make('Localización')
                ->description('Datos geograficos')
                ->schema([
                    Card::make()
                        ->schema([
                            // Forms\Components\TextInput::make('name')
                            //     ->label('Nombre')
                            //     ->required()
                            //     ->maxLength(256),
                            Forms\Components\TextInput::make('location.lat')
                                ->maxLength(32),
                            Forms\Components\TextInput::make('location.lng')
                                ->maxLength(32),
                            Forms\Components\TextInput::make('location.premise')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('location.street')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('location.city')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('location.state')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('location.zip')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('location.formatted_address')
                                // ->default('San Miguel Sigüilá, Guatemala')
                                ->maxLength(1024),
                            Forms\Components\Textarea::make('location.geojson'),
                            Forms\Components\Textarea::make('location.description'),
                            Geocomplete::make('location.location')
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
                            Map::make('location.location')
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
                                // ->geoJsonContainsField('geojson', 'CVEGEO')
                                ->geolocate()
                                // ->geolocateLabel('Set Location')
                                ->columnSpan(2),
                        ])
                ]),
        ];
    }
}
