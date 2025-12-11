<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producent extends Model
{
    protected $table = 'producenci';
    public $timestamps = false;
    
    protected $fillable = ['nazwa', 'opis'];

    public function sprzety(): HasMany
    {
        return $this->hasMany(Sprzet::class, 'producent_id');
    }
}
