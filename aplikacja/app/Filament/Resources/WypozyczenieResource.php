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
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Sprzet;

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
                    ->description('Podstawowe informacje o transakcji')
                    ->schema([
                        Forms\Components\TextInput::make('numer_zamowienia')
                            ->label('Numer zamówienia')
                            ->default(fn () => 'WYP-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT))
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('uzytkownik_id')
                            ->relationship('uzytkownik', 'email', function ($query) {
                                return $query->whereHas('rola', function ($q) {
                                    $q->where('klucz', 'klient');
                                });
                            })
                            ->label('Klient')
                            ->searchable(['imie', 'nazwisko', 'email'])
                            ->preload()
                            ->required()
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->imie} {$record->nazwisko} ({$record->email})"),
                        Forms\Components\Select::make('pracownik_id')
                            ->relationship('pracownik', 'email', function ($query) {
                                return $query->whereHas('rola', function ($q) {
                                    $q->whereIn('klucz', ['pracownik', 'admin']);
                                });
                            })
                            ->label('Obsługujący pracownik')
                            ->searchable(['imie', 'nazwisko', 'email'])
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->imie} {$record->nazwisko}"),
                        Forms\Components\Select::make('status_id')
                            ->relationship('status', 'nazwa')
                            ->label('Status wypożyczenia')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Terminy')
                    ->description('Daty związane z wypożyczeniem')
                    ->schema([
                        Forms\Components\DateTimePicker::make('data_rezerwacji')
                            ->label('Data rezerwacji')
                            ->default(now())
                            ->required()
                            ->displayFormat('d.m.Y H:i')
                            ->seconds(false),
                        Forms\Components\DateTimePicker::make('data_odbioru')
                            ->label('Data odbioru')
                            ->required()
                            ->displayFormat('d.m.Y H:i')
                            ->seconds(false)
                            ->after('data_rezerwacji')
                            ->validationMessages([
                                'after' => 'Data odbioru musi być późniejsza niż data rezerwacji.',
                            ]),
                        Forms\Components\DateTimePicker::make('data_zwrotu')
                            ->label('Planowana data zwrotu')
                            ->required()
                            ->displayFormat('d.m.Y H:i')
                            ->seconds(false)
                            ->after('data_odbioru')
                            ->validationMessages([
                                'after' => 'Data zwrotu musi być późniejsza niż data odbioru.',
                            ]),
                        Forms\Components\DateTimePicker::make('faktyczna_data_zwrotu')
                            ->label('Faktyczna data zwrotu')
                            ->displayFormat('d.m.Y H:i')
                            ->seconds(false),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Sprzęt')
                    ->description('Pozycje wypożyczenia')
                    ->schema([
                        Forms\Components\Repeater::make('sprzety')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('id')
                                    ->label('Sprzęt')
                                    ->options(function () {
                                        return Sprzet::where('status_sprzetu', 'dostepny')
                                            ->get()
                                            ->mapWithKeys(fn ($s) => [
                                                $s->id => "{$s->nazwa} ({$s->numer_seryjny}) - {$s->cena_doba} PLN/doba"
                                            ]);
                                    })
                                    ->searchable()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $sprzet = Sprzet::find($state);
                                        if ($sprzet) {
                                            $set('pivot.cena_netto_snapshot', $sprzet->cena_doba);
                                        }
                                    }),
                                Forms\Components\TextInput::make('pivot.cena_netto_snapshot')
                                    ->label('Cena za dobę (PLN)')
                                    ->required()
                                    ->numeric()
                                    ->prefix('PLN'),
                                Forms\Components\TextInput::make('pivot.rabat_procent')
                                    ->label('Rabat (%)')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->suffix('%'),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->reorderable(false)
                            ->addActionLabel('Dodaj sprzęt do wypożyczenia'),
                    ]),
                    
                Forms\Components\Section::make('Finanse')
                    ->description('Podsumowanie finansowe')
                    ->schema([
                        Forms\Components\TextInput::make('suma_calkowita')
                            ->label('Suma całkowita')
                            ->required()
                            ->numeric()
                            ->prefix('PLN')
                            ->helperText('Suma netto + kaucje'),
                        Forms\Components\Textarea::make('uwagi')
                            ->label('Uwagi')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Dodatkowe informacje o wypożyczeniu...'),
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
