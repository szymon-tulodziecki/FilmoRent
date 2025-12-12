<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Platnosc extends Model
{
    protected $table = 'platnosci';
    const CREATED_AT = 'utworzono_data';
    const UPDATED_AT = null;
    
    protected $fillable = [
        'wypozyczenie_id', 'kwota', 'typ', 'metoda', 'status', 'zewnetrzne_id',
    ];

    protected $casts = [
        'kwota' => 'decimal:2',
    ];

    public function wypozyczenie(): BelongsTo
    {
        return $this->belongsTo(Wypozyczenie::class, 'wypozyczenie_id');
    }
}
