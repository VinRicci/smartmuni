<?php

namespace App\Filament\Resources;

use Closure;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TagsColumn;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Fieldset;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $navigationGroup = 'Gestión de Administrador';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->description('Recuerde asignar el rol correcto para cada usuario.')
                    ->schema([
                        // ...
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->maxLength(255)
                            ->hiddenOn('edit')
                            ->required()
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->visibleOn('create')
                            ->confirmed(),
                        TextInput::make('password_confirmation')
                            ->label('Confimar contraseña')
                            ->password()
                            ->maxLength(255)
                            ->hiddenOn('edit')
                            ->required()
                            ->visibleOn('create'),
                        Fieldset::make('')
                            ->schema([
                                // ...
                                Toggle::make('is_admin')
                                    ->label('Administrador')
                                    ->helperText("Solo habilitar si el usuario tiene permiso de manejar registros."),
                            ]),
                        Fieldset::make('Roles')
                            ->schema([
                                // ...
                                CheckboxList::make('roles')
                                    ->label("")
                                    ->relationship('roles', 'name')
                                    ->columns(2)
                                    ->helperText('Escoge solo un rol.')
                                    ->required(),
                            ]),

                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                // IconColumn::make('is_admin')
                //     ->boolean(),
                TagsColumn::make('roles.name')->sortable()->searchable(),
                TextColumn::make('email'),
                TextColumn::make('email_verified_at')
                    ->dateTime(),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
                //
            RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
