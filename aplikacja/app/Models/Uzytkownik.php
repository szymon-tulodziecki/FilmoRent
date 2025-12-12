<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Uzytkownik extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $table = 'uzytkownicy';
    const CREATED_AT = 'utworzono_data';
    const UPDATED_AT = 'zaktualizowano_data';

    protected $fillable = [
        'rola_id', 'imie', 'nazwisko', 'email', 'haslo', 'telefon',
    ];

    protected $hidden = ['haslo', 'remember_token'];

    public function getAuthPassword(): string
    {
        return $this->haslo;
    }

    /**
     * Filament wymaga atrybutu 'name' - zwracamy pełne imię i nazwisko
     */
    public function getNameAttribute(): string
    {
        return "{$this->imie} {$this->nazwisko}";
    }

    /**
     * Sprawdza czy użytkownik może zalogować się do panelu Filament
     * Tylko administratorzy i pracownicy mają dostęp do CRM
     */
    public function canAccessPanel(Panel $panel): bool
    {
        $rolaKlucz = $this->rola?->klucz;
        return in_array($rolaKlucz, ['admin', 'pracownik']);
    }

    public function rola(): BelongsTo
    {
        return $this->belongsTo(Rola::class, 'rola_id');
    }

    public function adresy(): HasMany
    {
        return $this->hasMany(Adres::class, 'uzytkownik_id');
    }

    public function wypozyczenia(): HasMany
    {
        return $this->hasMany(Wypozyczenie::class, 'uzytkownik_id');
    }

    public function getPelneImieAttribute(): string
    {
        return "{$this->imie} {$this->nazwisko}";
    }

    public function maRole(string $klucz): bool
    {
        return $this->rola->klucz === $klucz;
    }
}
