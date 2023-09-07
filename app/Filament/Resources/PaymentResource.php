<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use App\Models\Residence;
use App\Models\Service;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Toggle;

// Filament components
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

//Other dependencies
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $modelLabel = 'Pagos de servicio';
    protected static ?string $pluralModelLabel = 'Pagos de servicios';
    protected static ?string $navigationLabel = 'Pagos de servicios';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')
                    ->label('Cantidad en quetzales')
                    ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'Q.', thousandsSeparator: ',', decimalPlaces: 2))
                    ->columnSpan('full')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set,callable $get) => $set('total', $get('amount')))
                    // ->afterStateUpdated(fn (callable $set,callable $get) => $set('balance', $get('amount')))
                    ->numeric(),
                Select::make('residence_id')
                    ->columnSpan('full')
                    ->required()
                    ->options(
                        Residence::all()->plucK('name', 'id')
                     )
                    ->label('Residencia'),
                Textarea::make('description')
                    ->columnSpan('full')
                    ->required()
                    ->label('Descripcion'),
                DatePicker::make('payment_date')
                    ->default(now())
                    ->required()
                    ->columnSpan('full')
                    ->label('Dia de realización'),
                DatePicker::make('deadline')
                    ->default(Carbon::now()->addDays(30))
                    ->columnSpan('full')
                    ->required()
                    ->label('Dia de corte'),
                Select::make('service_id')
                    ->columnSpan('full')
                    ->required()
                    ->relationship('service', 'name')
                    ->label('Servicio'),
                Select::make('status')
                    ->columnSpan('full')
                    ->required()
                    ->options([
                        'Por pagar' => 'por pagar',
                        'Cancelada' => 'cancelada',
                    ])
                    ->default('Por pagar')
                    ->label('Estado del pago'),    
                Toggle::make('is_mora')
                    ->label('Aplica cargo por mora')
                    ->inline(false)
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set,callable $get) =>(($get('is_mora')) ? $set('total', $get('amount')*floatval(Service::find($get('service_id'))->delay_percentage)) :$set('total', $get('amount')))),
                TextInput::make('total')
                    ->columnSpan('full')
                    ->default(0)
                    ->required()
                    ->disabled()
                    // ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'Q.', thousandsSeparator: ',', decimalPlaces: 2))
                    ->label('Total'),
                TextInput::make('balance')
                    ->columnSpan('full')
                    ->required()
                    ->disabled()
                    ->default(0)
                    // ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'Q.', thousandsSeparator: ',', decimalPlaces: 2))
                    ->label('Balance'),
                TextInput::make('user_id')
                    ->columnSpan('full')
                    ->required()
                    ->disabled()
                    ->default(Auth::user()->id)
                    ->label('Autor/a'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service')
                    ->label('Servicio')
                    ->getStateUsing(function (Model $record) {
                        return $record->service->name;
                    }),
                TextColumn::make('payment_date')
                    ->label('Fecha de corte'),
                TextColumn::make('residence')
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
                TextColumn::make('status')
                    ->searchable()
                    ->label('Estado'),
                TextColumn::make('balance')
                    ->label('balance'),
                TextColumn::make('total'),
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
            RelationManagers\PaymentHistoryRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }    
}
