<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->unique()
                ->required(),

            Select::make('department_id')
                ->label('Departamento')
                ->options(Department::all()->pluck('name', 'id'))
                ->required(),

            TextInput::make('alias')
                ->required()
                ->maxLength(50),

            TextInput::make('password')
                ->label('Contraseña')
                ->password()
                ->default(fn() => Str::random(12))
                ->required()
                ->rule(Password::default()),

            Select::make('is_admin')
                ->label('Es Administrador?')
                ->options([
                    0 => 'No',
                    1 => 'Sí'
                ])
                ->default(0)
                ->required(),
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
