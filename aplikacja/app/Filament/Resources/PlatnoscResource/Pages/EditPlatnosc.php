<?php

namespace App\Filament\Resources\PlatnoscResource\Pages;

use App\Filament\Resources\PlatnoscResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlatnosc extends EditRecord
{
    protected static string $resource = PlatnoscResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
