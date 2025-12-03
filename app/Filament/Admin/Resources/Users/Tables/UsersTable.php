<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use App\Filament\Admin\Exports\UserExporter;
use App\Filament\Admin\Imports\UserImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\ImportAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Enums\GlobalSearchPosition;
use Filament\Pages\Page;
use Filament\Schemas\Components\Group;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use OpenSpout\Writer\XLSX\Options\PageOrientation;
use Psy\Input\FilterOptions;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('gpms.no_users_yet'))
            ->emptyStateActions([
                CreateAction::make(),
            ])
            ->paginationMode(PaginationMode::Default)
            ->columns([
                TextColumn::make('name')
                    ->label(__('gpms.users.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('gpms.users.email'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')
                    ->label(__('gpms.users.phone'))
                    ->toggleable(),
                ImageColumn::make('avatar')
                    ->label(__('gpms.users.avatar'))
                    ->imageHeight(50)
                    ->disk('public')
                    ->defaultImageUrl('/images/default_avatar.png')
                    ->circular(),

                TextColumn::make('role')
                    ->label(__('gpms.users.role'))
                    ->badge()
                    ->colors([
                        'danger' => 'super_admin',
                        'warning' => 'supervisor',
                        'info' => 'student',
                        'success' => 'admin',
                    ])
                // ->formatStateUsing(fn(string $state): string => match ($state) {

                //     'supervisor' => 'مشرف',
                //     'admin' => 'مدير',
                //     'student' => 'طالب',
                //     default => $state,
                // }),
                ,
                TextColumn::make('last_login')
                    ->dateTime('Y-m-d h:i A')
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('Y-m-d h:i A')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime('Y-m-d h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime('Y-m-d h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('role')
                    ->label(__('gpms.users.role'))
                    ->multiple()
                    ->options([
                        'student' => __('gpms.roles.student'),
                        'supervisor' => __('gpms.roles.supervisor'),
                        'admin' => __('gpms.roles.admin'),
                        'super_admin' => __('gpms.roles.super_admin'),
                    ]),
                // TernaryFilter::make()
                // ->label('Email verification')
                // ->nullable()
                // ->placeholder('All users')
                // ->trueLabel('Verified users')
                // ->falseLabel('Not verified users')
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc')
            ->headerActions([
            CreateAction::make(),
            ImportAction::make()->importer(UserImporter::class),
            ExportAction::make()
                ->exporter(UserExporter::class)
                ->formats([
                    ExportFormat::Csv,
                    ExportFormat::Xlsx
                ])


        ])
        ;
    }
}
