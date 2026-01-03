<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix CSRF token HTML validation: hidden input fields should not have autocomplete attribute
        Blade::directive('csrf', function () {
            return "<?php echo '<input type=\"hidden\" name=\"_token\" value=\"' . csrf_token() . '\">'; ?>";
        });

        // Przyciski dostępności w górnym pasku (po zalogowaniu)
        FilamentView::registerRenderHook(
            'panels::global-search.after',
            fn (): string => Blade::render('@include(\'filament.components.accessibility-toolbar\')')
        );
        
        // Przyciski dostępności na stronie logowania (przed zalogowaniem)
        FilamentView::registerRenderHook(
            'panels::auth.login.form.before',
            fn (): string => Blade::render('@include(\'filament.components.login-accessibility\')')
        );
        
        // System timeout sesji
        FilamentView::registerRenderHook(
            'panels::body.end',
            fn (): string => Blade::render('@include(\'filament.components.session-timeout\')')
        );
    }
}
