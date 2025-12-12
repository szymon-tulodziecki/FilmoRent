<?php

namespace App\Filament\Resources\AdresResource\Pages;

use App\Filament\Resources\AdresResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdres extends ListRecords
{
    protected static string $resource = AdresResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
