<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wypozyczenie extends Model
{
    use HasFactory;

    protected $table = 'wypozyczenia';
    const CREATED_AT = 'utworzono_data';
    const UPDATED_AT = 'zaktualizowano_data';
    
    protected $fillable = [
        'numer_zamowienia', 'uzytkownik_id', 'pracownik_id', 'status_id',
        'data_rezerwacji', 'data_odbioru', 'data_zwrotu', 
        'faktyczna_data_zwrotu', 'suma_calkowita', 'uwagi',
    ];

    protected $casts = [
        'data_rezerwacji' => 'datetime',
        'data_odbioru' => 'datetime',
        'data_zwrotu' => 'datetime',
        'faktyczna_data_zwrotu' => 'datetime',
        'suma_calkowita' => 'decimal:2',
    ];

    public function uzytkownik(): BelongsTo
    {
        return $this->belongsTo(Uzytkownik::class, 'uzytkownik_id');
    }

    public function pracownik(): BelongsTo
    {
        return $this->belongsTo(Uzytkownik::class, 'pracownik_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(StatusWypozyczenia::class, 'status_id');
    }

    public function sprzety(): BelongsToMany
    {
        return $this->belongsToMany(Sprzet::class, 'elementy_wypozyczenia', 'wypozyczenie_id', 'sprzet_id')
                    ->withPivot(['cena_netto_snapshot', 'rabat_procent']);
    }

    public function platnosci(): HasMany
    {
        return $this->hasMany(Platnosc::class, 'wypozyczenie_id');
    }

    public static function generujNumerZamowienia(): string
    {
        $rok = date('Y');
        $miesiac = date('m');
        $ostatnie = static::whereYear('utworzono_data', $rok)->whereMonth('utworzono_data', $miesiac)->count();
        return "RENT/{$rok}/{$miesiac}/" . str_pad($ostatnie + 1, 4, '0', STR_PAD_LEFT);
    }
}
