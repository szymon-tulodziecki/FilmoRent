<?php

namespace App\Filament\Resources\WiadomoscKontaktowaResource\Pages;

use App\Filament\Resources\WiadomoscKontaktowaResource;
use Filament\Resources\Pages\ListRecords;

class ListWiadomosciKontaktowe extends ListRecords
{
    protected static string $resource = WiadomoscKontaktowaResource::class;
    
    protected static ?string $title = 'Wiadomości kontaktowe';
}
