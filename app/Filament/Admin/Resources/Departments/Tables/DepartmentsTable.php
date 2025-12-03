<?php

namespace App\Filament\Admin\Resources\Departments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Actions\HeaderActionsPosition;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Support\Htmlable;

class DepartmentsTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('gpms.departments.empty_state_heading'))
            ->emptyStateDescription(__('gpms.departments.empty_state_description'))
            ->emptyStateActions([
                CreateAction::make(),
            ])
            ->columns([
                TextColumn::make('faculty.name')
                    ->label(__('gpms.departments.faculty'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('gpms.departments.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('dept_head')
                    ->label(__('gpms.departments.head'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('students_count')
                    ->label(__('gpms.departments.students_count'))
                    ->counts('students')
                    ->sortable(),

                TextColumn::make('supervisors_count')
                    ->label(__('gpms.departments.supervisors_count'))
                    ->counts('supervisors')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->label(__('gpms.departments.status'))
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->formatStateUsing(
                        fn(string $state): string =>
                        $state === 'active' ? __('gpms.statuses.active') : __('gpms.statuses.inactive')
                    ),

                TextColumn::make('created_at')
                    ->label(__('gpms.departments.created_at'))
                    ->dateTime('Y-m-d')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('faculty')
                    ->label(__('gpms.departments.faculty'))
                    ->relationship('faculty', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->label(__('gpms.departments.status'))
                    ->options([
                        'active' => __('gpms.statuses.active'),
                        'inactive' => __('gpms.statuses.inactive'),
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
