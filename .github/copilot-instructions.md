# Copilot Instructions — gpms_admin_panal (GPMS)

Purpose: be surgical — prefer Filament generators, follow the multi-panel provider pattern, and keep edits small and localized.

Stack: Laravel 12 (PHP 8.2+), Filament 4 + Livewire, Vite, Sanctum, Spatie/Permission, FilamentShield. Locally uses SQLite (database/database.sqlite).

Quick setup (Windows PowerShell):
```powershell
composer run setup    # installs + .env/key/migrations + npm build
```

Dev (recommended):
```powershell
composer run dev      # concurrently: php artisan serve, queue listener, vite dev
```

Tests & formatting:
```powershell
composer run test
./vendor/bin/pint
```

Architecture — key facts (minimal):
- The repo uses Filament panel providers (AdminPanelProvider at `app/Providers/Filament/AdminPanelProvider.php`). The admin panel resources, pages, widgets live under `app/Filament/Admin/` (Resources/Pages/Widgets).
- Resources are modular: Resource classes live alongside `Schemas/` and `Tables/` classes (e.g., `app/Filament/Admin/Resources/Projects/`), which keep forms and table columns separated.
- Filament Provider patterns: register panels and customize branding, middleware, pages, widgets, and plugins (see `AdminPanelProvider::panel()` for examples).

Conventions & patterns you must respect:
- Use `--panel=<name>` when scaffolding Filament resources to ensure proper discovery and routing.
- Migrations follow numeric prefix + timestamp; FKs are commonly nullable; models often use `SoftDeletes` and `HasFactory`.
- Localization/RTL: LanguageSwitch is configured (see `AppServiceProvider`) and Filament will render RTL when configured; modify `resources/lang/*` for translation adjustments.
- Permissions: `spatie/laravel-permission` + FilamentShield (`BezhanSalleh/filament-shield`) are in use. Add roles via seeders and update `config/permission.php`.

Common tasks & typical file references:
- Add a resource (admin):
  php artisan make:filament-resource Project --model=App\\Models\\Project --panel=admin
  Files: `app/Filament/Admin/Resources/Projects/`
- Add a Filament page/widget: `php artisan make:filament-page` / `make:filament-widget` with --panel
- Panels: create a new PanelProvider in `app/Providers/Filament/` and add `->discoverResources(in: app_path('Filament/<Panel>/Resources'), for: 'App\\Filament\\<Panel>\\Resources')`.
- Seeding: `php artisan db:seed` (e.g., `DatabaseSeeder` creates initial admin user + roles).

Dev tips & safety checks:
- Sanity: run `composer run setup` on a fresh clone to avoid missing .env or sqlite. The script touches `database/database.sqlite` if not present.
- After changing Filament views/templates, run `php artisan filament:assets` and/or `php artisan filament:cache-components`.
- For cache clearing, run:
  ```powershell
  composer dump-autoload; php artisan optimize:clear; php artisan view:clear; php artisan cache:clear; php artisan route:clear
  ```
- Be cautious changing the `PanelProvider` defaults (branding/middleware) — this controls the whole panel UI and auth behavior.
- Those `AdminPanelProvider::panel()` calls show how navigation and plugins (e.g., FilamentShield) are applied.

Where to look first for a change:
- Registrations & panels: `app/Providers/Filament/AdminPanelProvider.php`
- Panel UI: `app/Filament/Admin/Resources/` (per-resource `Schemas`/`Tables` directories)
- Localization: `resources/lang/` and `AppServiceProvider.php` for LanguageSwitch
- Permissions & roles: `config/permission.php`, `database/seeders/*`.

When in doubt: keep edits localized and follow the `Schemas/Tables/Pages` modular pattern; prefer Filament generators to avoid routing/registration mistakes.

Questions or unclear details? Leave a short note and point to the provider + resource files involved, I’ll iterate.
