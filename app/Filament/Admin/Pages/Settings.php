<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\StatsOverview;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsIconAlias;
use Illuminate\Contracts\Support\Htmlable;

class Settings extends Page
{
    protected static bool $shouldRegisterNavigation = false;
    protected ?string $heading = '';
    protected static ?string $title = null;

    public function getTitle(): string | Htmlable
    {
        return __('gpms.settings');
    }

    protected function getHeaderActions(): array
    {
        return [

            Action::make('show_notifications')
                ->label(__('gpms.show_notifications'))
                ->button()
                ->icon(Heroicon::ArrowUpTray)
                ->action(function () {
        $recipient = Filament::auth()->user();

                    Notification::make()
                        ->title(__('gpms.show_notifications'))
                        ->success()->actions([
                            Action::make('view')
                                ->label(__('gpms.view'))
                                ->url('#')
                            // ->openUrlInNewTab(),
                        ])
                        // ->persistent()
                        ->sendToDatabase($recipient);
                }),
        ];
    }


    protected string $view = 'filament.pages.settings';
}
