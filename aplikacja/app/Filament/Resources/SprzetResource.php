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
                Forms\Components\Section::make('Podstawowe informacje')
                    ->description('Informacje identyfikacyjne sprzętu')
                    ->schema([
                        Forms\Components\Select::make('kategoria_id')
                            ->relationship('kategoria', 'nazwa')
                            ->label('Kategoria')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nazwa')
                                    ->label('Nazwa kategorii')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\Select::make('rodzic_id')
                                    ->relationship('rodzic', 'nazwa')
                                    ->label('Kategoria nadrzędna'),
                            ]),
                        Forms\Components\Select::make('producent_id')
                            ->relationship('producent', 'nazwa')
                            ->label('Producent')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nazwa')
                                    ->label('Nazwa producenta')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\Textarea::make('opis')
                                    ->label('Opis producenta')
                                    ->rows(3),
                            ]),
                        Forms\Components\TextInput::make('nazwa')
                            ->label('Nazwa sprzętu')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('np. Sony FX3 Full-Frame')
                            ->autofocus(),
                        Forms\Components\TextInput::make('numer_seryjny')
                            ->label('Numer seryjny')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->placeholder('SN-XXXXXXXX-001'),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Opis')
                    ->description('Szczegółowy opis i specyfikacja')
                    ->schema([
                        Forms\Components\Textarea::make('opis')
                            ->label('Szczegółowy opis')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Profesjonalny sprzęt filmowy, specyfikacja techniczna...'),
                    ]),
                    
                Forms\Components\Section::make('Wycena i status')
                    ->description('Informacje finansowe i dostępność')
                    ->schema([
                        Forms\Components\TextInput::make('cena_doba')
                            ->label('Cena za dobę (PLN)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('PLN')
                            ->step(0.01),
                        Forms\Components\TextInput::make('kaucja')
                            ->label('Kaucja (PLN)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('PLN')
                            ->step(0.01)
                            ->helperText('Zabezpieczenie przy wydaniu sprzętu'),
                        Forms\Components\TextInput::make('wartosc_rynkowa')
                            ->label('Wartość rynkowa (PLN)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('PLN')
                            ->step(0.01)
                            ->helperText('Wartość odtworzeniowa dla ubezpieczyciela'),
                        Forms\Components\Select::make('status_sprzetu')
                            ->label('Status')
                            ->options([
                                'dostepny' => 'Dostępny',
                                'wypozyczony' => 'Wypożyczony',
                                'w_serwisie' => 'W serwisie',
                                'niedostepny' => 'Niedostępny',
                                'wycofany' => 'Wycofany',
                                'zaginiony' => 'Zaginiony',
                            ])
                            ->required()
                            ->default('dostepny')
                            ->native(false),
                    ])->columns(2),
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
