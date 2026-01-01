<?php

namespace App\Filament\Resources\SprzetResource\Pages;

use App\Filament\Resources\SprzetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSprzets extends ListRecords
{
    protected static string $resource = SprzetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Dodaj Sprzęt'),
        ];
    }
}
