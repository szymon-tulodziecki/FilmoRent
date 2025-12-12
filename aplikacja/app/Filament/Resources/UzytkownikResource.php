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
            RelationManagers\AdresyRelationManager::class,
            RelationManagers\WypozyczenieRelationManager::class,
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
