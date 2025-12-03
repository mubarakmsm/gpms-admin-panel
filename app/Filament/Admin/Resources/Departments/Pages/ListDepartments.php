<?php

namespace App\Filament\Admin\Resources\Departments\Pages;

use App\Filament\Admin\Resources\Departments\DepartmentResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Livewire\Notifications;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;
    protected static ?string $title = null;

    protected function getHeaderActions(): array
    {

        return [
            CreateAction::make()
                ->label(__('gpms.add_department')),
            Action::make('show_notifications')
                ->label(__('gpms.show_notifications'))
                ->button()
                ->icon(Heroicon::ArrowUpTray)
                ->action(function () {
                    $recipient = Filament::auth()->user();

                    $recipient->notify(
                        Notification::make()
                            ->title(__('gpms.saved_successfully'))
                            ->toDatabase(),
                    );
                }),
        ];
    }

    public function getTitle(): string
    {
        return __('gpms.departments.title');
    }
}
