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

class ResponsibleResource extends Resource
{
    protected static ?string $model = Responsible::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
