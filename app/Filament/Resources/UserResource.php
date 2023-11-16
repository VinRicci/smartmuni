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
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Fieldset;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
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
                            ->label('Correo')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->maxLength(255)
                            ->hiddenOn('edit')
                            ->required()
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
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
                                    ->label("Roles")
                                    ->relationship('roles', 'name')
                                    ->columns(2)
                                    ->helperText('Agregar Roles')
                                    ->required(),
                            ]),

                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nombre'),
                // IconColumn::make('is_admin')
                //     ->boolean(),
                TagsColumn::make('roles.name')->sortable()->searchable()->label('Roles'),
                TextColumn::make('email')->label('Correo'),
                TextColumn::make('email_verified_at')->label('Fecha de verificacíon')
                    ->dateTime(),
                TextColumn::make('created_at')->label('Fecha de creación')
                    ->dateTime(),
            ])->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()->label('Editar'),
                    Tables\Actions\DeleteAction::make()->label('Eliminar'),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\Action::make('logs')
                        ->url(fn ($record) => UserResource::getUrl('logs', ['record' => $record]))
                        ->label('Actividad de registros')
                        ->color('success')
                        ->icon('heroicon-o-clock'),
                    ExportAction::make()->exports([
                        ExcelExport::make('Exportar tabla')->fromTable(),
                        ExcelExport::make('Exportar modelo')->fromForm(),
                    ])
                ])


            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                // ExportBulkAction::make()
                ExportBulkAction::make()->exports([
                    ExcelExport::make('Exportar tabla')->fromTable(),
                    ExcelExport::make('Exportar modelo')->fromForm(),
                ])
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
            'logs' => Pages\LogUsers::route('/{record}/logs'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
