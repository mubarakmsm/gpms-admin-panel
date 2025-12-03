<?php

namespace App\Filament\Admin\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label(__('gpms.users.id')),
            ExportColumn::make('name')->label(__('gpms.users.name')),
            ExportColumn::make('email')->label(__('gpms.users.email')),
            ExportColumn::make('phone')->label(__('gpms.users.phone')),
            ExportColumn::make('avatar')->label(__('gpms.users.avatar')),
            ExportColumn::make('role')->label(__('gpms.users.role')),
            ExportColumn::make('last_login')->label(__('gpms.users.last_login')),
            ExportColumn::make('created_at')->label(__('gpms.users.created_at')),
            ExportColumn::make('updated_at')->label(__('gpms.users.updated_at')),
            ExportColumn::make('deleted_at')->label(__('gpms.users.deleted_at')),
        ];
    }



    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your user export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
