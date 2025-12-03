<?php

namespace App\Filament\Admin\Resources\Faculties\Pages;

use App\Filament\Admin\Resources\Faculties\FacultyResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFaculty extends EditRecord
{
    protected static string $resource = FacultyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    // }
}
