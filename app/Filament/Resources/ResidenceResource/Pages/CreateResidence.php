<?php

namespace App\Filament\Resources\ResidenceResource\Pages;

use App\Filament\Resources\ResidenceResource;
use App\Models\Sector;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
// use Filament\Forms\Components\Grid;
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
                ->description('Detallar los datos de la vivienda')
                ->schema([
                    Card::make()
                        ->schema([
                            TextInput::make('name')
                                ->label('Nombre de la vivienda')
                                ->required()
                                ->reactive(),
                            Select::make('residence_type_id')
                                ->required()
                                ->label('Tipo de residencia')
                                ->relationship('residence_type', 'name'),
                            Select::make('village_id')
                                ->reactive()
                                ->required()
                                ->label('Aldea')
                                ->relationship('village', 'name')
                                ->afterStateUpdated(function ($state, $set) {
                                    $set('sector_id', Sector::query()->where('village_id', $state)->pluck('name', 'id'));
                                }),
                            Select::make('sector_id')
                                ->required()
                                ->label('Sector')
                                ->relationship('sector', 'name', fn (Builder $query, $get) => $query->where('village_id', $get('village_id')))
                                ->reactive()
                        ])

                ]),
            Step::make('Responsable')
                ->description('Datos del responsable')
                ->schema([
                    Card::make()
                        ->schema([
                            Group::make()
                                ->relationship('responsible')
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->minLength(2)
                                        ->maxLength(100)
                                        ->label('Nombre del responsable'),
                                    TextInput::make('dpi')
                                        ->required()
                                        ->mask(fn (TextInput\Mask $mask) => $mask->pattern('0000 00000 0000'))
                                        ->label('DPI'),
                                    TextInput::make('email')
                                        ->email()
                                        ->label('Correo electrónico'),
                                    TextInput::make('phone')
                                        ->tel()
                                        ->prefix('+502')
                                        ->mask(fn (TextInput\Mask $mask) => $mask->pattern('00000000'))
                                        // ->disableAutocomplete()
                                        ->placeholder(__('00000000'))
                                        ->label('Número de teléfono'),
                                ])
                        ]),

                ]),
            Step::make('Localización')
                ->description('Datos geográficos')
                ->schema([
                    Card::make()
                        ->schema([

                            Group::make()

                                ->relationship('location')

                                ->schema([

                                    Grid::make([
                                        // 'default' => 1,
                                        'sm' => 1,
                                        'md' => 2,
                                        'lg' => 2,
                                        'xl' => 2,
                                        // '2xl' => 8,
                                    ])
                                        ->schema([
                                            Forms\Components\TextInput::make('lat')
                                                ->columnSpan(['sm' => 2, 'xl' => 1])
                                                ->label('Latitud')
                                                ->maxLength(32),
                                            Forms\Components\TextInput::make('lng')
                                                ->columnSpan(['sm' => 2, 'xl' => 1])
                                                ->label('Longitud')
                                                ->maxLength(32),
                                            Forms\Components\TextInput::make('premise')
                                                ->columnSpan(['sm' => 2, 'xl' => 1])
                                                ->label('Premisa')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('street')
                                                ->columnSpan(['sm' => 2, 'xl' => 1])
                                                ->label('Calle')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('city')
                                                ->columnSpan(['sm' => 2, 'xl' => 1])
                                                ->label('Ciudad')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('state')
                                                ->columnSpan(['sm' => 2, 'xl' => 1])
                                                ->label('Municipio')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('zip')
                                                ->columnSpan(['sm' => 2, 'xl' => 1])
                                                ->label('Zip')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('formatted_address')
                                                ->columnSpan(['sm' => 2, 'xl' => 1])
                                                ->label('dirección formateada')
                                                // ->default('San Miguel Sigüilá, Guatemala')
                                                ->maxLength(1024),
                                            Forms\Components\Textarea::make('geojson')
                                                ->columnSpan(1)
                                                ->required(),
                                            Forms\Components\Textarea::make('description')
                                                ->columnSpan(1)
                                                ->label('descripción')
                                                ->required(),
                                            Geocomplete::make('location')
                                                ->columnSpan(1)
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
                                                // ->geoJsonContainsField('geojson', 'CVEGEO')
                                                ->geolocate()
                                                // ->geolocateLabel('Set Location')
                                                ->columnSpan(['sm' => 2, 'xl' => 2]),
                                        ])

                                ])
                        ])



                ]),
        ];
    }

    public function hasSkippableSteps(): bool
    {
        return true;
    }
}
