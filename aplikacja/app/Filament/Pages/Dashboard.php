<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AccessibilityWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Panel główny';
    
    protected static ?string $title = 'Panel główny';

    public function getWidgets(): array
    {
        return [
            AccessibilityWidget::class,
        ];
    }
    
    public function getColumns(): int | string | array
    {
        return 1;
    }
}
