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
        'opis', 'url_zdjecia', 'cena_doba', 'kaucja', 'wartosc_rynkowa', 'status_sprzetu',
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
    
    public function getZdjecieUrl(): string
    {
        if ($this->url_zdjecia) {
            return $this->url_zdjecia;
        }
        
        // Mapy stabilnych zdjęć z Unsplash - prawdziwy sprzęt filmowy
        $photoMaps = [
            'Kamery' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=800&q=80', // Kamera Sony
            'Obiektywy' => 'https://images.unsplash.com/photo-1606925797300-0b35e9d1794e?w=800&q=80', // Obiektyw Canon
            'Oświetlenie' => 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?w=800&q=80', // Studio lighting
            'Statywy i Gimbale' => 'https://images.unsplash.com/photo-1516961642265-531546e84af2?w=800&q=80', // Statyw
            'Audio' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?w=800&q=80', // Mikrofon studyjny
            'Światło' => 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?w=800&q=80', // Studio lighting
            'Grip' => 'https://images.unsplash.com/photo-1516961642265-531546e84af2?w=800&q=80', // Statyw
            'Dźwięk' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?w=800&q=80', // Mikrofon
        ];
        
        $categoryName = $this->kategoria?->nazwa;
        
        return $photoMaps[$categoryName] ?? 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=800&q=80';
    }
}
