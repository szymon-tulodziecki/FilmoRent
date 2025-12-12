<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sprzet extends Model
{
    use HasFactory;

    protected $table = 'sprzet';
    const CREATED_AT = 'utworzono_data';
    const UPDATED_AT = 'zaktualizowano_data';
    
    protected $fillable = [
        'kategoria_id', 'producent_id', 'nazwa', 'numer_seryjny',
        'opis', 'cena_doba', 'kaucja', 'wartosc_rynkowa', 'status_sprzetu',
    ];

    protected $casts = [
        'cena_doba' => 'decimal:2',
        'kaucja' => 'decimal:2',
        'wartosc_rynkowa' => 'decimal:2',
    ];

    public function kategoria(): BelongsTo
    {
        return $this->belongsTo(Kategoria::class, 'kategoria_id');
    }

    public function producent(): BelongsTo
    {
        return $this->belongsTo(Producent::class, 'producent_id');
    }

    public function wypozyczenia(): BelongsToMany
    {
        return $this->belongsToMany(Wypozyczenie::class, 'elementy_wypozyczenia', 'sprzet_id', 'wypozyczenie_id')
                    ->withPivot(['cena_netto_snapshot', 'rabat_procent']);
    }

    public function czyDostepny(): bool
    {
        return $this->status_sprzetu === 'dostepny';
    }
}
