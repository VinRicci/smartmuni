<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResponsibleResource\Pages;
use App\Filament\Resources\ResponsibleResource\RelationManagers;
use App\Models\Responsible;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
// use Filament\Forms\Form;
use Filament\Forms\Components\Group;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Columns\BadgeColumn;

class ResponsibleResource extends Resource
{
    protected static ?string $model = Responsible::class;

    protected static ?string $navigationGroup = 'Censo';
    protected static ?string $navigationIcon = 'ri-user-location-line';

    protected static ?string $modelLabel = 'Responsable';
    protected static ?string $pluralModelLabel = 'Responsables';
    protected static ?string $navigationLabel = 'Responsables';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->columns(1)
                    ->schema([

                        Section::make('Información del responsable')
                            ->schema([
                                Select::make('gender')
                                    ->label('Genero')
                                    ->required()
                                    ->options([
                                        'male' => 'Masculino',
                                        'female' => 'Femenino',
                                    ]),
                                Forms\Components\TextInput::make('name')
                                    ->maxValue(50)
                                    ->required(),
                                TextInput::make('dpi')
                                    ->label('DPI'),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email address')
                                    ->required()
                                    ->email()
                                    ->unique(ignoreRecord: true),

                                Forms\Components\TextInput::make('phone')
                                    ->maxValue(50),

                                Forms\Components\DatePicker::make('birthday')
                                    ->maxDate('today'),
                            ])
                            ->columns(2),


                        Forms\Components\Section::make('Archivos')
                            ->description('Solo puedes subir un maximo de 10 archivos')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('documents')
                                    ->multiple()
                                    ->enableDownload()
                                    ->disk('media')
                                    ->maxFiles(10)
                                    ->enableOpen()
                                    ->preserveFilenames()
                                    ->disableLabel(),
                            ])
                            ->collapsible(),

                    ])->columnSpan(['lg' => fn (?Responsible $record) => $record === null ? 2 : 2]),




                Group::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('avatar')
                                    ->id('avatar')
                                    ->collection('avatar')
                                    ->enableReordering()
                                    ->disk('media')
                                    ->preserveFilenames()
                                    ->enableDownload()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                                    ->enableOpen(),
                            ])
                            ->columnSpan(['lg' => 1]),

                        Forms\Components\Card::make()

                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn (Responsible $record): ?string => $record->created_at?->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn (Responsible $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Responsible $record) => $record === null),
                    ]),







            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->columns([
            //     TextColumn::make('name')
            //         ->label('Nombre'),
            // ])

            ->columns([
                Split::make([
                    SpatieMediaLibraryImageColumn::make('avatar')
                        ->getStateUsing(
                            function ($record) {
                                $data = json_encode($record, true);
                                $arrayData = json_decode($data, true);
                                $bandera = false;
                                foreach ($arrayData['media'] as $elemento) {
                                    $collectionName = $elemento['collection_name'];
                                    \Log::info($collectionName);
                                    if($collectionName === 'avatar'){
                                        $bandera = true;
                                    }
                                }
                                if (isset($arrayData['media']) && is_array($arrayData['media']) && empty($arrayData['media'] && $bandera)) {
                                    \Log::info('Viene vacio');

                                    return 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=FFFFFF&background=111827';
                                }
                            }

                        )
                        ->collection('avatar')
                        ->toggleable()
                        ->circular()
                        ->grow(false),

                    Stack::make([
                        TextColumn::make('name')
                            ->weight('bold')
                            ->toggleable()
                            ->searchable()
                            ->limit(20)
                            ->sortable(),
                        TextColumn::make('email')
                            ->limit(20),
                    ]),
                    Stack::make([
                        BadgeColumn::make('gender')
                            ->enum([
                                'male' => 'Masculino',
                                'female' => 'Femenino',
                            ])
                            ->colors([
                                'warning' => 'female',
                                'success' => 'male',

                            ]),
                        TextColumn::make('dpi')
                            ->sortable()
                            ->searchable()
                            ->toggleable()
                            ->label(__('DPI')),
                    ]),

                    Stack::make([
                        TextColumn::make('created_at')
                            ->sortable()
                            ->searchable()
                            ->toggleable()
                            ->dateTime()
                            ->label(__('Fecha de creación')),
                    ]),
                ]),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ])

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListResponsibles::route('/'),
            'create' => Pages\CreateResponsible::route('/create'),
            'view' => Pages\ViewResponsible::route('/{record}'),
            'edit' => Pages\EditResponsible::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
