<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsenceResource\Pages;
use App\Filament\Resources\AbsenceResource\RelationManagers;
use App\Models\Absence;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class AbsenceResource extends Resource
{
    protected static ?string $model = Absence::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gestión de Ausencias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Profesor'),
                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required()
                    ->label('Departamento'),
                DatePicker::make('date')
                    ->required()
                    ->label('Fecha de ausencia'),
                Select::make('hour')
                    ->options([
                        'H1' => 'Hora 1',
                        'H2' => 'Hora 2',
                        'H3' => 'Hora 3',
                        'H4' => 'Hora 4',
                        'H5' => 'Hora 5',
                        'H6' => 'Hora 6',
                        'R1' => 'Recreo 1',
                        'R2' => 'Recreo 2',
                    ])
                    ->required()
                    ->label('Hora'),
                Textarea::make('comment')
                    ->label('Comentario')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Profesor'),
                TextColumn::make('department.name')->label('Departamento'),
                TextColumn::make('date')->label('Fecha'),
                TextColumn::make('hour')->label('Hora'),
                TextColumn::make('comment')->label('Comentario')->limit(255),
                TextColumn::make('created_at')->label('Registrado el')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAbsences::route('/'),
            'create' => Pages\CreateAbsence::route('/create'),
            'edit' => Pages\EditAbsence::route('/{record}/edit'),
        ];
    }
    
    public static function canAccess(): bool
    {
        return auth()->user()->is_admin;
    }
}
