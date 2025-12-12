<?php

namespace App\Filament\Resources\UzytkownikResource\Pages;

use App\Filament\Resources\UzytkownikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUzytkownik extends EditRecord
{
    protected static string $resource = UzytkownikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
