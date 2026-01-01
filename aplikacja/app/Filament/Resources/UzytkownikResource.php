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
use Illuminate\Support\Facades\Hash;
use Filament\Facades\Filament;

class UzytkownikResource extends Resource
{
    protected static ?string $model = Uzytkownik::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'Użytkownicy';
    
    protected static ?string $modelLabel = 'Użytkownik';
    
    protected static ?string $pluralModelLabel = 'Użytkownicy';
    
    protected static ?string $navigationGroup = 'Użytkownicy';
    
    protected static ?string $slug = 'uzytkownicy';

    public static function getNavigationLabel(): string
    {
        return 'Użytkownicy';
    }

    public static function getModelLabel(): string
    {
        return 'Użytkownik';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Użytkownicy';
    }

    public static function getCreateLabel(): string
    {
        return 'Dodaj Użytkownika';
    }

    public static function getEditLabel(): string
    {
        return 'Edytuj Użytkownika';
    }

    /**
     * Pracownik nie widzi administratorów
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        $user = Filament::auth()->user();
        
        // Jeśli zalogowany użytkownik to pracownik - nie pokazuj administratorów
        if ($user && $user->rola?->klucz === 'pracownik') {
            $query->whereHas('rola', function ($q) {
                $q->where('klucz', '!=', 'admin');
            });
        }
        
        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dane osobowe')
                    ->description('Podstawowe informacje o użytkowniku')
                    ->schema([
                        Forms\Components\TextInput::make('imie')
                            ->label('Imię')
                            ->required()
                            ->maxLength(100)
                            ->autocomplete('given-name')
                            ->autofocus(),
                        Forms\Components\TextInput::make('nazwisko')
                            ->label('Nazwisko')
                            ->required()
                            ->maxLength(100)
                            ->autocomplete('family-name'),
                        Forms\Components\TextInput::make('email')
                            ->label('Adres email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->autocomplete('email')
                            ->helperText('Adres email będzie używany do logowania'),
                        Forms\Components\TextInput::make('telefon')
                            ->label('Numer telefonu')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('+48 XXX XXX XXX'),
                    ])->columns(2),

                Forms\Components\Section::make('Profil klienta')
                    ->description('Typ klienta oraz dane indywidualne lub firmowe')
                    ->schema([
                        Forms\Components\Select::make('typ_klienta')
                            ->label('Typ klienta')
                            ->options([
                                'indywidualny' => 'Klient indywidualny',
                                'biznesowy' => 'Klient biznesowy',
                            ])
                            ->required()
                            ->reactive(),

                        Forms\Components\TextInput::make('pesel')
                            ->label('PESEL')
                            ->maxLength(11)
                            ->visible(fn (callable $get) => $get('typ_klienta') === 'indywidualny'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nazwa_firmy')
                                    ->label('Nazwa firmy')
                                    ->maxLength(255)
                                    ->visible(fn (callable $get) => $get('typ_klienta') === 'biznesowy'),
                                Forms\Components\TextInput::make('nip')
                                    ->label('NIP')
                                    ->maxLength(10)
                                    ->visible(fn (callable $get) => $get('typ_klienta') === 'biznesowy'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('regon')
                                    ->label('REGON')
                                    ->maxLength(14)
                                    ->visible(fn (callable $get) => $get('typ_klienta') === 'biznesowy'),
                                Forms\Components\TextInput::make('osoba_kontaktowa')
                                    ->label('Osoba kontaktowa')
                                    ->maxLength(255)
                                    ->visible(fn (callable $get) => $get('typ_klienta') === 'biznesowy'),
                            ]),

                        Forms\Components\TextInput::make('stanowisko')
                            ->label('Stanowisko')
                            ->maxLength(100)
                            ->visible(fn (callable $get) => $get('typ_klienta') === 'biznesowy'),

                        Forms\Components\Select::make('status_klienta')
                            ->label('Status klienta')
                            ->options([
                                'aktywny' => 'Aktywny',
                                'wstrzymany' => 'Wstrzymany',
                                'zablokowany' => 'Zablokowany',
                            ])
                            ->default('aktywny')
                            ->required(),

                        Forms\Components\Textarea::make('notatki_crm')
                            ->label('Notatki CRM')
                            ->rows(3)
                            ->maxLength(2000),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Konto i uprawnienia')
                    ->description('Konfiguracja dostępu i roli użytkownika')
                    ->schema([
                        Forms\Components\Select::make('rola_id')
                            ->relationship('rola', 'nazwa', function ($query) {
                                // Pracownik nie może przypisać roli Administrator
                                $user = Filament::auth()->user();
                                if ($user && $user->rola?->klucz === 'pracownik') {
                                    $query->where('klucz', '!=', 'admin');
                                }
                                return $query;
                            })
                            ->label('Rola w systemie')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Administrator - pełny dostęp | Pracownik - zarządzanie wypożyczeniami | Klient - przeglądanie i rezerwacje'),
                        Forms\Components\TextInput::make('haslo')
                            ->label('Hasło')
                            ->password()
                            ->required(fn ($context) => $context === 'create')
                            ->minLength(8)
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->helperText('Minimum 8 znaków. Pozostaw puste aby nie zmieniać hasła.'),
                        Forms\Components\DateTimePicker::make('zweryfikowany_email_data')
                            ->label('Data weryfikacji email')
                            ->helperText('Pozostaw puste jeśli email nie został zweryfikowany'),
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
                Tables\Columns\BadgeColumn::make('typ_klienta')
                    ->label('Typ klienta')
                    ->colors([
                        'success' => 'indywidualny',
                        'warning' => 'biznesowy',
                    ])
                    ->formatStateUsing(fn (string $state) => $state === 'biznesowy' ? 'Biznesowy' : 'Indywidualny'),
                Tables\Columns\BadgeColumn::make('status_klienta')
                    ->label('Status')
                    ->colors([
                        'success' => 'aktywny',
                        'warning' => 'wstrzymany',
                        'danger' => 'zablokowany',
                    ])
                    ->formatStateUsing(function (string $state) {
                        return [
                            'aktywny' => 'Aktywny',
                            'wstrzymany' => 'Wstrzymany',
                            'zablokowany' => 'Zablokowany',
                        ][$state] ?? $state;
                    }),
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
                Tables\Actions\ViewAction::make()->label('Podgląd'),
                Tables\Actions\EditAction::make()->label('Edytuj'),
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
