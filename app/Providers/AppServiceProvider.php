<?php

namespace App\Providers;

use BezhanSalleh\LanguageSwitch\Enums\Placement;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
         LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
            ->excludes([
                'app'
            ])
            ->circular()
            //  ->renderHook('panels::global-search.before')
            ->outsidePanelPlacement(Placement::TopRight)
                ->locales(['ar','en']); // also accepts a closure
        });
        Schema::defaultStringLength(191);
    }
}
