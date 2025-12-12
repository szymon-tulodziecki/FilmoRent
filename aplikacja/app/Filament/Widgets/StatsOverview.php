<?php

namespace App\Filament\Widgets;

use App\Models\Sprzet;
use App\Models\Uzytkownik;
use App\Models\Wypozyczenie;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Łączna liczba sprzętu', Sprzet::count())
                ->description('Wszystkie pozycje w magazynie')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make('Aktywne wypożyczenia', Wypozyczenie::where('status_id', 1)->count())
                ->description('Obecnie wypożyczone')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Zarejestrowani klienci', Uzytkownik::count())
                ->description('Użytkownicy w systemie')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Wszystkie wypożyczenia', Wypozyczenie::count())
                ->description('Historia wszystkich transakcji')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning'),
        ];
    }
}
