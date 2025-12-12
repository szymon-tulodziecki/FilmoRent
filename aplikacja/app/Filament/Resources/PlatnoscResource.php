<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlatnoscResource\Pages;
use App\Filament\Resources\PlatnoscResource\RelationManagers;
use App\Models\Platnosc;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlatnoscResource extends Resource
{
    protected static ?string $model = Platnosc::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    
    protected static ?string $navigationLabel = 'Płatności';
    
    protected static ?string $modelLabel = 'Płatność';
    
    protected static ?string $pluralModelLabel = 'Płatności';
    
    protected static ?string $navigationGroup = 'Transakcje';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('wypozyczenie_id')
                    ->relationship('wypozyczenie', 'numer_zamowienia')
                    ->label('Wypożyczenie')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('kwota')
                    ->label('Kwota')
                    ->required()
                    ->numeric()
                    ->prefix('PLN'),
                Forms\Components\Select::make('typ')
                    ->label('Typ płatności')
                    ->options([
                        'zaliczka' => 'Zaliczka',
                        'kaucja' => 'Kaucja',
                        'pelna' => 'Pełna płatność',
                        'zwrot' => 'Zwrot',
                    ])
                    ->required(),
                Forms\Components\Select::make('metoda')
                    ->label('Metoda płatności')
                    ->options([
                        'gotowka' => 'Gotówka',
                        'karta' => 'Karta',
                        'przelew' => 'Przelew',
                        'blik' => 'BLIK',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'oczekujaca' => 'Oczekująca',
                        'zrealizowana' => 'Zrealizowana',
                        'anulowana' => 'Anulowana',
                        'zwrocona' => 'Zwrócona',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('zewnetrzne_id')
                    ->label('ID zewnętrzne (terminal/bank)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wypozyczenie.numer_zamowienia')
                    ->label('Nr wypożyczenia')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kwota')
                    ->label('Kwota')
                    ->money('PLN')
                    ->sortable(),
                Tables\Columns\TextColumn::make('typ')
                    ->label('Typ')
                    ->badge(),
                Tables\Columns\TextColumn::make('metoda')
                    ->label('Metoda')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'zrealizowana' => 'success',
                        'oczekujaca' => 'warning',
                        'anulowana' => 'danger',
                        'zwrocona' => 'info',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('utworzono_data')
                    ->label('Data')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('utworzono_data', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'oczekujaca' => 'Oczekująca',
                        'zrealizowana' => 'Zrealizowana',
                        'anulowana' => 'Anulowana',
                        'zwrocona' => 'Zwrócona',
                    ]),
                Tables\Filters\SelectFilter::make('metoda')
                    ->label('Metoda')
                    ->options([
                        'gotowka' => 'Gotówka',
                        'karta' => 'Karta',
                        'przelew' => 'Przelew',
                        'blik' => 'BLIK',
                    ]),
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
            'index' => Pages\ListPlatnoscs::route('/'),
            'create' => Pages\CreatePlatnosc::route('/create'),
            'edit' => Pages\EditPlatnosc::route('/{record}/edit'),
        ];
    }
}
