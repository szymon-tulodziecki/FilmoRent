<?php

namespace App\Filament\Resources\UzytkownikResource\Pages;

use App\Filament\Resources\UzytkownikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUzytkowniks extends ListRecords
{
    protected static string $resource = UzytkownikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Dodaj Użytkownika'),
        ];
    }
}
