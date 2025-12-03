<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Exports\UserExporter;
use App\Filament\Admin\Imports\UserImporter;
use App\Filament\Admin\Resources\Users\UserResource;
use Faker\Core\File;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use UnitEnum;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
     protected static ?string $title = '';


protected function getTableHeaderActions(): array
{
    return [
        CreateAction::make()
        ->after(function (CreateAction $action) {
            $action->redirect($this->getResource()::getUrl('index'));
        })
            ->label(__('gpms.add_user')),
    ];
}

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
