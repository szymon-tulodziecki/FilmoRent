<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdresResource\Pages;
use App\Filament\Resources\AdresResource\RelationManagers;
use App\Models\Adres;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdresResource extends Resource
{
    protected static ?string $model = Adres::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('uzytkownik_id')
                    ->relationship('uzytkownik', 'id')
                    ->required(),
                Forms\Components\TextInput::make('ulica')
                    ->required(),
                Forms\Components\TextInput::make('miasto')
                    ->required(),
                Forms\Components\TextInput::make('kod_pocztowy')
                    ->required(),
                Forms\Components\TextInput::make('typ')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uzytkownik.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ulica')
                    ->searchable(),
                Tables\Columns\TextColumn::make('miasto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kod_pocztowy')
                    ->searchable(),
                Tables\Columns\TextColumn::make('typ')
                    ->searchable(),
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
            'index' => Pages\ListAdres::route('/'),
            'create' => Pages\CreateAdres::route('/create'),
            'edit' => Pages\EditAdres::route('/{record}/edit'),
        ];
    }
}
