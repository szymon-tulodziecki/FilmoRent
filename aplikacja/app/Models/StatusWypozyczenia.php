<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusWypozyczenia extends Model
{
    protected $table = 'statusy_wypozyczenia';
    public $timestamps = false;
    
    protected $fillable = ['nazwa', 'klucz', 'kolor'];

    public function wypozyczenia(): HasMany
    {
        return $this->hasMany(Wypozyczenie::class, 'status_id');
    }
}
