<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UzytkownikResource\Pages;
use App\Filament\Resources\UzytkownikResource\RelationManagers;
use App\Models\Uzytkownik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UzytkownikResource extends Resource
{
    protected static ?string $model = Uzytkownik::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'Klienci';
    
    protected static ?string $modelLabel = 'Klient';
    
    protected static ?string $pluralModelLabel = 'Klienci';
    
    protected static ?string $navigationGroup = 'Użytkownicy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dane osobowe')
                    ->schema([
                        Forms\Components\TextInput::make('imie')
                            ->label('Imię')
                            ->required(),
                        Forms\Components\TextInput::make('nazwisko')
                            ->label('Nazwisko')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('telefon')
                            ->label('Telefon')
                            ->tel(),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Konto')
                    ->schema([
                        Forms\Components\Select::make('rola_id')
                            ->relationship('rola', 'nazwa')
                            ->label('Rola')
                            ->required(),
                        Forms\Components\TextInput::make('haslo')
                            ->label('Hasło')
                            ->password()
                            ->required(fn ($context) => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state)),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('imie')
                    ->label('Imię')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nazwisko')
                    ->label('Nazwisko')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('telefon')
                    ->label('Telefon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rola.nazwa')
                    ->label('Rola')
                    ->badge()
                    ->sortable(),
                Tables\Columns\IconColumn::make('zweryfikowany_email_data')
                    ->label('Zweryfikowany')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rola')
                    ->relationship('rola', 'nazwa')
                    ->label('Rola'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUzytkowniks::route('/'),
            'create' => Pages\CreateUzytkownik::route('/create'),
            'edit' => Pages\EditUzytkownik::route('/{record}/edit'),
        ];
    }
}
