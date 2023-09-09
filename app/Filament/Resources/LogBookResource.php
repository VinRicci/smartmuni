<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogBookResource\Pages;
use App\Filament\Resources\LogBookResource\RelationManagers;
use App\Models\logbook;
use App\Models\Service;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

use Illuminate\Database\Eloquent\Model;

class LogBookResource extends Resource
{
    protected static ?string $model = logbook::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Administración';

    protected static ?string $modelLabel = 'Historial de pago';
    protected static ?string $pluralModelLabel = 'Historial de pago';
    protected static ?string $navigationLabel = 'Historial de pago';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')
                    ->label('Cantidad')
                    ->disabled(),
                TextInput::make('description')
                    ->label('Descripcion')
                    ->disabled(),
                DatePicker::make('created_at')
                    ->disabled()
                    ->label('Fecha de realizacion'),
                Select::make('residence_id')
                    ->disabled()
                    ->relationship('residence', 'name')
                    ->label('Residencia'),
                Select::make('service_id')
                    ->disabled()
                    ->relationship('service', 'name')
                    ->label('Servicio'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')
                    ->label('Cantidad')
                    ->disabled(),
                TextColumn::make('description')
                    ->label('Descripcion')
                    ->disabled(),
                TextColumn::make('created_at')
                    ->label('Fecha de realizacion'),
                TextColumn::make('residence_id')
                    ->label('Residencia')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->whereHas('residence', function (Builder $q) use($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->getStateUsing(function (Model $record) {
                        return $record->residence->name;
                    }),
                TextColumn::make('service_id')
                    ->label('Servicio')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->whereHas('service', function (Builder $q) use($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->getStateUsing(function (Model $record) {
                        return $record->service->name;
                    }),
                
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
            'index' => Pages\ListLogBooks::route('/'),
            // 'create' => Pages\CreateLogBook::route('/create'),
            // 'edit' => Pages\EditLogBook::route('/{record}/edit'),
        ];
    }    
}
