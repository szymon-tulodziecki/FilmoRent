<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WiadomoscKontaktowa extends Model
{
    protected $table = 'wiadomosci_kontaktowe';

    protected $fillable = [
        'imie_nazwisko',
        'email',
        'temat',
        'wiadomosc',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
