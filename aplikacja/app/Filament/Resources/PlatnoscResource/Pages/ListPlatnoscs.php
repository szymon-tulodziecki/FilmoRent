<?php

namespace App\Filament\Resources\PlatnoscResource\Pages;

use App\Filament\Resources\PlatnoscResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlatnoscs extends ListRecords
{
    protected static string $resource = PlatnoscResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
