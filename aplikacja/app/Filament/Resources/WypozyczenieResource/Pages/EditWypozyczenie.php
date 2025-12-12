<?php

namespace App\Filament\Resources\WypozyczenieResource\Pages;

use App\Filament\Resources\WypozyczenieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWypozyczenie extends EditRecord
{
    protected static string $resource = WypozyczenieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
