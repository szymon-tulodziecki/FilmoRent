<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adres extends Model
{
    protected $table = 'adresy';
    public $timestamps = false;
    
    protected $fillable = ['uzytkownik_id', 'ulica', 'miasto', 'kod_pocztowy', 'typ'];

    public function uzytkownik(): BelongsTo
    {
        return $this->belongsTo(Uzytkownik::class, 'uzytkownik_id');
    }
}
