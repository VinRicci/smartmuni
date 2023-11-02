<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResponsibleResource\Pages;
use App\Filament\Resources\ResponsibleResource\RelationManagers;
use App\Models\Responsible;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ActionGroup;

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

use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;

class ResponsibleResource extends Resource
{
    protected static ?string $model = Responsible::class;

    protected static ?string $navigationGroup = 'Censo';
    protected static ?string $navigationIcon = 'ri-user-location-line';

    protected static ?string $modelLabel = 'Responsables';
    protected static ?string $pluralModelLabel = 'Responsable';
    protected static ?string $navigationLabel = 'Responsables';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre'),
                TextInput::make('dpi')
                    ->label('DPI'),
                TextInput::make('email')
                    ->label('Correo'),
                TextInput::make('phone')
                    ->label('telefono'),
                SpatieMediaLibraryFileUpload::make('photo')
                    ->id('photo')
                    // ->label(function ($context) {
                    //     if ($context == 'edit') return __('employees.documents.personal');
                    //     return '';
                    // })
                    ->collection('photo')
                    ->enableReordering()
                    ->disk('media')
                    ->enableDownload()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->enableOpen(),

            ]);
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
                    ImageColumn::make('avatar')
                        ->getStateUsing(fn (
                            $record
                        ) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=FFFFFF&background=111827')
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
                        TextColumn::make('title')
                            ->sortable()
                            ->searchable()
                            ->toggleable()
                            ->label(__('title')),
                        TextColumn::make('department.name')
                            ->sortable()
                            // ->badge()
                            ->searchable()
                            ->toggleable()
                            // ->visible(fn (): bool => WindPlugin::get()->hasDepartmentResource())
                            ->label(__('department')),
                    ]),

                    Stack::make([
                        TextColumn::make('created_at')
                            ->sortable()
                            ->searchable()
                            ->toggleable()
                            ->dateTime()
                            ->label(__('sent at')),
                        // TextColumn::make('status')
                        //     // ->formatStateUsing(fn (string $state): string => __("status_{$state}"))
                        //     ->label(__('status'))
                        //     ->sortable()
                        //     ->searchable()
                        //     ->toggleable()
                        //     // ->badge()
                        //     ->color(fn (string $state): string => match ($state) {
                        //         'NEW' => 'danger',
                        //         'REPLIED' => 'gray',
                        //         'READ' => 'success',
                        //         default => '',
                        //     }),
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
