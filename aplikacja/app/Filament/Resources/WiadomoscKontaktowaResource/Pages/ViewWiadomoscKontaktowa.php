<?php

namespace App\Filament\Resources\WiadomoscKontaktowaResource\Pages;

use App\Filament\Resources\WiadomoscKontaktowaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWiadomoscKontaktowa extends ViewRecord
{
    protected static string $resource = WiadomoscKontaktowaResource::class;
    
    protected static ?string $title = 'Szczegóły wiadomości';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('oznacz_przeczytana')
                ->label('Oznacz jako przeczytaną')
                ->icon('heroicon-o-eye')
                ->color('warning')
                ->visible(fn () => $this->record->status === 'nowa')
                ->action(fn () => $this->record->update(['status' => 'przeczytana'])),
            Actions\Action::make('oznacz_odpowiedziana')
                ->label('Oznacz jako odpowiedzianą')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $this->record->status !== 'odpowiedziana')
                ->action(fn () => $this->record->update(['status' => 'odpowiedziana'])),
        ];
    }
}
