<?php

namespace App\Filament\Resources\WiadomoscKontaktowaResource\Pages;

use App\Filament\Resources\WiadomoscKontaktowaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWiadomoscKontaktowa extends EditRecord
{
    protected static string $resource = WiadomoscKontaktowaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
