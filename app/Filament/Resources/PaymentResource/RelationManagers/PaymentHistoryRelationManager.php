<?php

namespace App\Filament\Resources\PaymentResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


// Filament components
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;

//Other dependencies
use Illuminate\Database\Eloquent\Model;
use App\Services\PaymentService;
use App\Services\LogBookService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentHistory';

    protected static ?string $recordTitleAttribute = 'Payment';

    protected static $paymentService;
    protected static $logbookService;

    public function __construct() {
        static::$paymentService = new PaymentService();
        static::$logbookService = new LogBookService();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('description')
                    ->default('Abono a factura ')
                    ->columnSpan('full')
                    ->required()
                    ->label('Descripcion'),
                DatePicker::make('payment_date')
                    ->default(now())
                    ->required()
                    ->columnSpan('full')
                    ->label('Dia de realización'),
                TextInput::make('amount')
                    ->label('Cantidad en quetzales')
                    ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'Q.', thousandsSeparator: ',', decimalPlaces: 2))
                    ->columnSpan('full')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('responsable')
                    ->label('Nombre/DPI de persona que lo hizo'),
                Toggle::make('is_fix')->label('Es una correción')->inline()->columnSpan('full')              
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               
                TextColumn::make('amount')
                    ->label('Cantidad'),
                TextColumn::make('payment_date')
                    ->datetime('Y-m-d')
                    ->label('Fecha de realizacion'),
                TextColumn::make('responsable')
                    ->label('DPI'),
                TextColumn::make('description')
                    ->label('Descripcion'),
                
                
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->after(function (RelationManager $livewire, Model $record) {
                    self::$paymentService->updateBalance($livewire->ownerRecord->id); 
                    self::$logbookService->insertALogBook($record->id, $livewire->ownerRecord->id);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (RelationManager $livewire) {
                        self::$paymentService->updateBalance($livewire->ownerRecord->id); 
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function (RelationManager $livewire) {
                        self::$paymentService->updateBalance($livewire->ownerRecord->id); 
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
