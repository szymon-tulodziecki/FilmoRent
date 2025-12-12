<?php

namespace App\Filament\Resources\UzytkownikResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AdresyRelationManager extends RelationManager
{
    protected static string $relationship = 'adresy';

    protected static ?string $title = 'Adresy';

    protected static ?string $recordTitleAttribute = 'ulica';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dane adresowe')
                    ->description('Adres klienta')
                    ->schema([
                        Forms\Components\TextInput::make('ulica')
                            ->label('Ulica i numer')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('ul. Przykładowa 15/3')
                            ->autofocus(),
                        Forms\Components\TextInput::make('miasto')
                            ->label('Miasto')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('kod_pocztowy')
                            ->label('Kod pocztowy')
                            ->required()
                            ->maxLength(20)
                            ->placeholder('00-000'),
                        Forms\Components\Select::make('typ')
                            ->label('Typ adresu')
                            ->options([
                                'rozliczeniowy' => 'Rozliczeniowy',
                                'dostawy' => 'Dostawy',
                            ])
                            ->required()
                            ->native(false),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ulica')
            ->columns([
                Tables\Columns\TextColumn::make('ulica')
                    ->label('Ulica')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('miasto')
                    ->label('Miasto')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kod_pocztowy')
                    ->label('Kod pocztowy')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('typ')
                    ->label('Typ')
                    ->colors([
                        'primary' => 'rozliczeniowy',
                        'success' => 'dostawy',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('typ')
                    ->label('Typ')
                    ->options([
                        'rozliczeniowy' => 'Rozliczeniowy',
                        'dostawy' => 'Dostawy',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Dodaj adres'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Brak adresów')
            ->emptyStateDescription('Dodaj pierwszy adres klienta.')
            ->emptyStateIcon('heroicon-o-map-pin');
    }
}
