<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use App\Models\Residence;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PaymentPerCustomer extends BaseWidget
{

    protected static ?string $heading = 'Tabla de pagos';

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    protected static ?bool $clustering = true;

    protected static ?bool $fitToBounds = true;

    protected static ?string $mapId = 'incidents';

    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Residence::query()->select('*');
    }



    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('domicile_number')
                ->label('Numero de casa'),
            Tables\Columns\TextColumn::make('responsible.name')
                ->label('Responsable'),
            Tables\Columns\TextColumn::make('Agua')
                ->getStateUsing(function (Model $record): float {
                    $total = 0;
                    $items = $record->payments;
                    foreach ($items as $item) {
                        if ($item['service_id'] == 1) {
                            $total += $item->amount;
                        }
                    }
                    return $total;
                })
                ->label('Agua'),
            Tables\Columns\TextColumn::make('Luz')
                ->getStateUsing(function (Model $record): float {
                    $total = 0;
                    $items = $record->payments;
                    foreach ($items as $item) {
                        if ($item['service_id'] == 2) {
                            $total += $item->amount;
                        }
                    }
                    return $total;
                })
                ->label('Luz'),  
        ];
    }
}
