<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Zalacznik extends Model
{
    protected $table = 'zalaczniki';

    const CREATED_AT = 'utworzono';
    const UPDATED_AT = 'zaktualizowano';

    protected $fillable = [
        'zalacznikowalny_type',
        'zalacznikowalny_id',
        'nazwa_pliku',
        'oryginalana_nazwa',
        'sciezka',
        'mime_type',
        'rozmiar_bajty',
    ];

    protected $casts = [
        'rozmiar_bajty' => 'integer',
    ];

    /**
     * Polimorficzna relacja - załącznik może należeć do różnych modeli
     */
    public function zalacznikowalny(): MorphTo
    {
        return $this->morphTo();
    }
}
