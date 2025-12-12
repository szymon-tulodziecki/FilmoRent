<?php

namespace App\Filament\Resources\UzytkownikResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class WypozyczenieRelationManager extends RelationManager
{
    protected static string $relationship = 'wypozyczenia';

    protected static ?string $title = 'Wypożyczenia';

    protected static ?string $recordTitleAttribute = 'numer_zamowienia';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numer_zamowienia')
                    ->label('Nr zamówienia')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\BadgeColumn::make('status.nazwa')
                    ->label('Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_odbioru')
                    ->label('Data odbioru')
                    ->date('d.m.Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_zwrotu')
                    ->label('Planowany zwrot')
                    ->date('d.m.Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('suma_calkowita')
                    ->label('Kwota')
                    ->money('PLN')
                    ->sortable(),
            ])
            ->defaultSort('data_rezerwacji', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->relationship('status', 'nazwa')
                    ->label('Status'),
            ])
            ->headerActions([
                // Można dodać możliwość tworzenia wypożyczenia
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->emptyStateHeading('Brak wypożyczeń')
            ->emptyStateDescription('Ten użytkownik nie ma jeszcze żadnych wypożyczeń.')
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
    }
}
