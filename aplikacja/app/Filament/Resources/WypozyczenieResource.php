<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WypozyczenieResource\Pages;
use App\Filament\Resources\WypozyczenieResource\RelationManagers;
use App\Models\Wypozyczenie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WypozyczenieResource extends Resource
{
    protected static ?string $model = Wypozyczenie::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $navigationLabel = 'Wypożyczenia';
    
    protected static ?string $modelLabel = 'Wypożyczenie';
    
    protected static ?string $pluralModelLabel = 'Wypożyczenia';
    
    protected static ?string $navigationGroup = 'Transakcje';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dane wypożyczenia')
                    ->schema([
                        Forms\Components\TextInput::make('numer_zamowienia')
                            ->label('Numer zamówienia')
                            ->required()
                            ->disabled(),
                        Forms\Components\Select::make('uzytkownik_id')
                            ->relationship('uzytkownik', 'email')
                            ->label('Klient')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('pracownik_id')
                            ->relationship('pracownik', 'email')
                            ->label('Obsługujący pracownik')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('status_id')
                            ->relationship('status', 'nazwa')
                            ->label('Status')
                            ->required(),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Terminy')
                    ->schema([
                        Forms\Components\DateTimePicker::make('data_rezerwacji')
                            ->label('Data rezerwacji')
                            ->required(),
                        Forms\Components\DateTimePicker::make('data_odbioru')
                            ->label('Data odbioru')
                            ->required(),
                        Forms\Components\DateTimePicker::make('data_zwrotu')
                            ->label('Planowana data zwrotu')
                            ->required(),
                        Forms\Components\DateTimePicker::make('faktyczna_data_zwrotu')
                            ->label('Faktyczna data zwrotu'),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Finanse')
                    ->schema([
                        Forms\Components\TextInput::make('suma_calkowita')
                            ->label('Suma całkowita')
                            ->required()
                            ->numeric()
                            ->prefix('PLN'),
                        Forms\Components\Textarea::make('uwagi')
                            ->label('Uwagi')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numer_zamowienia')
                    ->label('Nr zamówienia')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('uzytkownik.email')
                    ->label('Klient')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.nazwa')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_odbioru')
                    ->label('Odbiór')
                    ->date('d.m.Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_zwrotu')
                    ->label('Zwrot')
                    ->date('d.m.Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('suma_calkowita')
                    ->label('Suma')
                    ->money('PLN')
                    ->sortable(),
            ])
            ->defaultSort('data_rezerwacji', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->relationship('status', 'nazwa')
                    ->label('Status'),
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
            'index' => Pages\ListWypozyczenies::route('/'),
            'create' => Pages\CreateWypozyczenie::route('/create'),
            'edit' => Pages\EditWypozyczenie::route('/{record}/edit'),
        ];
    }
}
