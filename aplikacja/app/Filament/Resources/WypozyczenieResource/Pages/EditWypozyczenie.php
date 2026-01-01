<?php

namespace App\Filament\Resources\WypozyczenieResource\Pages;

use App\Filament\Resources\WypozyczenieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditWypozyczenie extends EditRecord
{
    protected static string $resource = WypozyczenieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Usuń'),
        ];
    }

    public function getTitle(): string
    {
        return 'Edytuj wypożyczenie';
    }

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        $user = auth()->user();
        $record = $this->getRecord();

        // Admin ma dostęp do wszystkich
        if ($user->rola?->klucz === 'admin') {
            return;
        }

        // Pracownik może edytować tylko swoje zamówienia
        if ($user->rola?->klucz === 'pracownik' && $record->pracownik_id !== $user->id) {
            abort(403, 'Możesz edytować tylko zamówienia przypisane do Ciebie.');
        }
    }
}
