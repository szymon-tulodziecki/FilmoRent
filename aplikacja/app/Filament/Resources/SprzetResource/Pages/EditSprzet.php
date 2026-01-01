<?php

namespace App\Filament\Resources\SprzetResource\Pages;

use App\Filament\Resources\SprzetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSprzet extends EditRecord
{
    protected static string $resource = SprzetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Usuń'),
        ];
    }

    public function getTitle(): string
    {
        return 'Edytuj sprzęt';
    }
}
