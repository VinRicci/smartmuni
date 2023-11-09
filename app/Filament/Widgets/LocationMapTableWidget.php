<?php

namespace App\Filament\Widgets;

use App\Models\Location;
use App\Models\Geocode;
use Cheesegrits\FilamentGoogleMaps\Actions\GoToAction;
use Cheesegrits\FilamentGoogleMaps\Actions\RadiusAction;
use Cheesegrits\FilamentGoogleMaps\Filters\MapIsFilter;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapTableWidget;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;

use Filament\Tables;
use Filament\Forms;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LocationMapTableWidget extends MapTableWidget
{
    protected static ?string $heading = 'Localización de mapas';

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    protected static ?bool $clustering = true;

    protected static ?bool $fitToBounds = true;

    protected static ?string $mapId = 'incidents';

    protected int | string | array $columnSpan = 'full';

    //    protected static ?bool $filtered = false;

    public ?bool $mapIsFilter = true;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Card::make()->schema([
                // Forms\Components\TextInput::make('name')
                //     ->maxLength(256),
                Forms\Components\TextInput::make('lat')
                    ->label('Latitud')
                    ->maxLength(32),
                Forms\Components\TextInput::make('lng')
                    ->label('Longitud')
                    ->maxLength(32),
                Forms\Components\TextInput::make('street')
                    ->label('Calle')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label('Ciudad')
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->label('Sector')
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip')
                    ->hidden()
                    ->maxLength(255),
                Forms\Components\TextInput::make('formatted_address')
                    ->label('Dirección')
                    ->maxLength(1024),

            ])
        ];
    }

    protected function getTableQuery(): Builder
    {
        // return Geocode::query()->latest();
        return Location::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('name')
            //     ->searchable(),
            //                Tables\Columns\TextColumn::make('lat'),
            //                Tables\Columns\TextColumn::make('lng'),
            Tables\Columns\TextColumn::make('street')
                ->label('Calle')
                ->searchable(),
            Tables\Columns\TextColumn::make('city')
                ->searchable()
                ->label('Ciudad')
                ->sortable(),
            Tables\Columns\TextColumn::make('state')
                ->searchable()
                ->label('Sector')
                ->sortable(),
            // Tables\Columns\TextColumn::make('zip'),
            Tables\Columns\TextColumn::make('formatted_address')
                ->label('Dirección'),
            MapColumn::make('location'),
            MapColumn::make('location')
                ->extraImgAttributes(
                    fn ($record): array => ['title' => $record->lat . ',' . $record->lng]
                )
                ->label('Localización')
                ->height('150')
                ->width('250')
                ->type('hybrid')
                ->zoom(15),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            RadiusFilter::make('location')
                ->section('Filtro por Radio')
                ->selectUnit(),
            // MapIsFilter::make('map'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make()
                ->form($this->getFormSchema()),
            Tables\Actions\EditAction::make()
                ->form($this->getFormSchema()),
            GoToAction::make()
                ->label('Ir')
                ->zoom(16),
            RadiusAction::make()->label('Radio'),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }

    protected function getData(): array
    {
        $locations = $this->getRecords();

        $data = [];

        foreach ($locations as $location) {
            $data[] = [
                'location' => [
                    'lat' => $location->lat ? round(floatval($location->lat), static::$precision) : 0,
                    'lng' => $location->lng ? round(floatval($location->lng), static::$precision) : 0,
                ],
                'label'    => $location->formatted_address,
                'id'       => $location->id,
            ];
        }

        return $data;
    }
}
