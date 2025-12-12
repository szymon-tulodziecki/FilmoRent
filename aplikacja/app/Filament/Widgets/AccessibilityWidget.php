<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AccessibilityWidget extends Widget
{
    protected static string $view = 'filament.widgets.accessibility-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = -1;

    // Widget ukryty - przyciski dostępności są w górnym pasku
    public static function canView(): bool
    {
        return false;
    }
}
