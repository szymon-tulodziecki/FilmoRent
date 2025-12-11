<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategoria extends Model
{
    protected $table = 'kategorie';
    public $timestamps = false;
    
    protected $fillable = ['nazwa', 'slug', 'rodzic_id'];

    public function rodzic(): BelongsTo
    {
        return $this->belongsTo(Kategoria::class, 'rodzic_id');
    }

    public function dzieci(): HasMany
    {
        return $this->hasMany(Kategoria::class, 'rodzic_id');
    }

    public function sprzety(): HasMany
    {
        return $this->hasMany(Sprzet::class, 'kategoria_id');
    }
}
