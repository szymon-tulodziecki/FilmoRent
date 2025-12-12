<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SprzetResource\Pages;
use App\Filament\Resources\SprzetResource\RelationManagers;
use App\Models\Sprzet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SprzetResource extends Resource
{
    protected static ?string $model = Sprzet::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    
    protected static ?string $navigationLabel = 'Sprzęt';
    
    protected static ?string $modelLabel = 'Sprzęt';
    
    protected static ?string $pluralModelLabel = 'Sprzęt';
    
    protected static ?string $navigationGroup = 'Magazyn';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kategoria_id')
                    ->relationship('kategoria', 'nazwa')
                    ->label('Kategoria')
                    ->required(),
                Forms\Components\Select::make('producent_id')
                    ->relationship('producent', 'nazwa')
                    ->label('Producent')
                    ->required(),
                Forms\Components\TextInput::make('nazwa')
                    ->label('Nazwa')
                    ->required(),
                Forms\Components\TextInput::make('numer_seryjny')
                    ->label('Numer seryjny')
                    ->required(),
                Forms\Components\Textarea::make('opis')
                    ->label('Opis')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cena_doba')
                    ->label('Cena za dobę (PLN)')
                    ->required()
                    ->numeric()
                    ->prefix('PLN'),
                Forms\Components\TextInput::make('kaucja')
                    ->label('Kaucja (PLN)')
                    ->required()
                    ->numeric()
                    ->prefix('PLN'),
                Forms\Components\TextInput::make('wartosc_rynkowa')
                    ->label('Wartość rynkowa (PLN)')
                    ->required()
                    ->numeric()
                    ->prefix('PLN'),
                Forms\Components\Select::make('status_sprzetu')
                    ->label('Status')
                    ->options([
                        'dostepny' => 'Dostępny',
                        'wypozyczony' => 'Wypożyczony',
                        'serwis' => 'W serwisie',
                        'niedostepny' => 'Niedostępny',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nazwa')
                    ->label('Nazwa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategoria.nazwa')
                    ->label('Kategoria')
                    ->sortable(),
                Tables\Columns\TextColumn::make('producent.nazwa')
                    ->label('Producent')
                    ->sortable(),
                Tables\Columns\TextColumn::make('numer_seryjny')
                    ->label('Nr seryjny')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cena_doba')
                    ->label('Cena/dobę')
                    ->money('PLN')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status_sprzetu')
                    ->label('Status')
                    ->colors([
                        'success' => 'dostepny',
                        'warning' => 'serwis',
                        'danger' => 'wypozyczony',
                        'secondary' => 'niedostepny',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_sprzetu')
                    ->label('Status')
                    ->options([
                        'dostepny' => 'Dostępny',
                        'wypozyczony' => 'Wypożyczony',
                        'serwis' => 'W serwisie',
                        'niedostepny' => 'Niedostępny',
                    ]),
                Tables\Filters\SelectFilter::make('kategoria')
                    ->relationship('kategoria', 'nazwa')
                    ->label('Kategoria'),
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
            'index' => Pages\ListSprzets::route('/'),
            'create' => Pages\CreateSprzet::route('/create'),
            'edit' => Pages\EditSprzet::route('/{record}/edit'),
        ];
    }
}
