<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AccessibilityWidget;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Panel główny';
    
    protected static ?string $title = 'Panel główny';

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            AccessibilityWidget::class,
        ];
    }
    
    public function getColumns(): int | string | array
    {
        return 2;
    }
}
