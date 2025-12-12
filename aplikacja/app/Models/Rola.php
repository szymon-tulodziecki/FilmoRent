<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rola extends Model
{
    protected $table = 'role';
    public $timestamps = false;
    
    protected $fillable = ['nazwa', 'klucz'];

    public function uzytkownicy(): HasMany
    {
        return $this->hasMany(Uzytkownik::class, 'rola_id');
    }
}
