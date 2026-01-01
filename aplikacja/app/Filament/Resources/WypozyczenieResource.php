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
use App\Filament\Resources\WypozyczenieResource\Pages\EditWypozyczenie;
use App\Filament\Resources\WypozyczenieResource\Pages\CreateWypozyczenie;
use App\Filament\Resources\WypozyczenieResource\Pages\ViewWypozyczenie;

class WypozyczenieResource extends Resource
{
    protected static ?string $model = Wypozyczenie::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $navigationLabel = 'Wypożyczenia';
    
    protected static ?string $modelLabel = 'Wypożyczenie';
    
    protected static ?string $pluralModelLabel = 'Wypożyczenia';
    
    protected static ?string $navigationGroup = 'Transakcje';
    
    protected static ?string $slug = 'wypozyczenia';

    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();
        if (!$user) {
            return null;
        }

        // Tylko dla pracowników i adminów
        if (!in_array($user->rola?->klucz, ['pracownik', 'admin'])) {
            return null;
        }

        $count = static::getModel()::query()
            ->where('pracownik_id', $user->id)
            ->whereHas('status', function ($query) {
                $query->whereIn('klucz', ['oczekuje', 'wRealizacji']);
            })
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getCreateLabel(): string
    {
        return 'Nowe Wypożyczenie';
    }

    public static function getEditLabel(): string
    {
        return 'Edytuj Wypożyczenie';
    }

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
                            ->disabled(fn ($record) => (bool) $record)
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
                            ->disabled(fn ($record) => (bool) $record)
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
                            ->default(fn () => auth()->id())
                            ->disabled(fn ($record) => (bool) $record)
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
                    ->visibleOn(CreateWypozyczenie::class)
                    ->hiddenOn('view')
                    ->schema([
                        Forms\Components\Repeater::make('sprzety')
                            ->relationship()
                            ->disabled(fn ($record) => (bool) $record)
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
                    ->visibleOn(CreateWypozyczenie::class)
                    ->hiddenOn('view')
                    ->schema([
                        Forms\Components\TextInput::make('suma_calkowita')
                            ->label('Suma całkowita')
                            ->required()
                            ->numeric()
                            ->disabled(fn ($record) => (bool) $record)
                            ->prefix('PLN')
                            ->helperText('Suma netto + kaucje'),
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
                Tables\Columns\TextColumn::make('pracownik.nazwisko')
                    ->label('Pracownik')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($record) => $record->pracownik ? "{$record->pracownik->imie} {$record->pracownik->nazwisko}" : '-'),
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
            ->defaultSort(fn ($query) => $query->orderByRaw("
                CASE 
                    WHEN EXISTS (
                        SELECT 1 FROM statusy_wypozyczenia 
                        WHERE statusy_wypozyczenia.id = wypozyczenia.status_id 
                        AND statusy_wypozyczenia.klucz IN ('oczekuje', 'wRealizacji')
                    ) THEN 0
                    ELSE 1
                END, data_rezerwacji DESC
            "))
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->relationship('status', 'nazwa')
                    ->label('Status'),
                Tables\Filters\SelectFilter::make('pracownik')
                    ->relationship('pracownik', 'nazwisko')
                    ->label('Pracownik')
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->imie} {$record->nazwisko}"),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Podgląd'),
                Tables\Actions\EditAction::make()
                    ->label('Edytuj')
                    ->visible(function ($record) {
                        $user = auth()->user();
                        // Admin widzi wszystkie
                        if ($user->rola?->klucz === 'admin') {
                            return true;
                        }
                        // Pracownik widzi tylko swoje
                        return $user->rola?->klucz === 'pracownik' && $record->pracownik_id === $user->id;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Usuń zaznaczone'),
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
            'view' => Pages\ViewWypozyczenie::route('/{record}'),
            'edit' => Pages\EditWypozyczenie::route('/{record}/edit'),
        ];
    }
}
