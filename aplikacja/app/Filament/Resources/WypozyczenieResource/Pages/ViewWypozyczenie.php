<?php

namespace App\Filament\Resources\WypozyczenieResource\Pages;

use App\Filament\Resources\WypozyczenieResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWypozyczenie extends ViewRecord
{
    protected static string $resource = WypozyczenieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Edytuj'),
        ];
    }

    public function getTitle(): string
    {
        return 'Podgląd wypożyczenia';
    }
}
