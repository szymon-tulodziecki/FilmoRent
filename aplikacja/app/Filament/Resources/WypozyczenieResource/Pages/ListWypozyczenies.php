<?php

namespace App\Filament\Resources\WypozyczenieResource\Pages;

use App\Filament\Resources\WypozyczenieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWypozyczenies extends ListRecords
{
    protected static string $resource = WypozyczenieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Wypożyczenia są tworzone automatycznie przez klientów z koszyka
        ];
    }
}
