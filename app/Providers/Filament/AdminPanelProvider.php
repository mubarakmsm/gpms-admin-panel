<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\Settings;
use App\Filament\Admin\Widgets\RecentActivity;
use App\Filament\Admin\Widgets\StatsOverview;
use App\Models\Team;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Actions\Action;
use Filament\Auth\MultiFactor\Contracts\MultiFactorAuthenticationProvider;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel

            ->default()
            ->profile()

            ->passwordReset()
            ->defaultThemeMode(ThemeMode::Dark)
            ->brandName('GPMS')
            ->maxContentWidth(Width::Full)
            ->databaseNotifications()
            // ->topNavigation()

            ->userMenuItems([
                Action::make('settings')
                    ->label(__('gpms.settings'))
                    ->url(fn(): string => Settings::getUrl())
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->favicon(asset('images/logo.png'))
            ->brandLogoHeight('6rem')
            ->darkModeBrandLogo(asset('images/logo.png'))
            ->brandLogo(asset('images/logo4.png'))
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('18rem')
            ->id('admin')
            ->path('admin')
            ->login()

            ->colors([

                'primary' => '#04192E',
                'gray' => Color::Slate,
                // 'primary' => Color::hex('#04192E'),
                // 'success' => Color::hex('#10B981'),
                // 'warning' => Color::hex('#F59E0B'),
                // 'danger' => Color::hex('#EF4444'),
                // 'info' => Color::hex('#3B82F6'),
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
           
            ->pages([
                Dashboard::class,

            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                // AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            ->plugins([
                FilamentShieldPlugin::make()
                    // ->navigationLabel('Label')                  // string|Closure|null
                    // ->navigationIcon('heroicon-o-home')         // string|Closure|null
                    // ->activeNavigationIcon('heroicon-s-home')   // string|Closure|null
                    ->navigationGroup('Permissions and Roles')                  // string|Closure|null
                    ->navigationSort(10)                        // int|Closure|null
                    // ->navigationBadge(Roles::count())                      // string|Closure|null
                    ->navigationBadgeColor('success')
                    ->localizePermissionLabels()
                    // ->gridColumns([
                    //     'default' => 1,
                    //     'sm' => 2,
                    //     'lg' => 3
                    // ])
                    // ->sectionColumnSpan(1)
                    // ->checkboxListColumns([
                    //     'default' => 1,
                    //     'sm' => 2,
                    //     'lg' => 4,
                    // ])
                    // ->resourceCheckboxListColumns([
                    //     'default' => 1,
                    //     'sm' => 2,
                    // ]),

            ])

        ;
    }
}
