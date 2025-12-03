<?php

namespace App\Filament\Admin\Resources\Faculties\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\SelectFilter;
class FacultiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->paginationMode(PaginationMode::Cursor)
            ->emptyStateHeading(__('gpms.faculties.empty_state_heading'))
                ->emptyStateDescription(__('gpms.faculties.empty_state_description'))
            ->emptyStateActions([
                CreateAction::make(),
            ])
            ->columns([
                
                TextColumn::make('name')
                    ->label(__('gpms.faculties.name'))
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('dean_name')
                    ->label(__('gpms.faculties.dean'))
                    ,
                
                TextColumn::make('departments_count')
                    ->label(__('gpms.faculties.departments_count'))
                    ->counts('departments')
                    ->sortable(),
                
                TextColumn::make('status')
                ->badge()
                    ->label(__('gpms.faculties.status'))
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->formatStateUsing(fn (string $state): string => 
                        $state === 'active' ? __('gpms.statuses.active') : __('gpms.statuses.inactive')
                    ),
                
                TextColumn::make('created_at')
                    ->label(__('gpms.faculties.created_at'))
                    ->dateTime('Y-m-d')
                    ->sortable(),
                
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('status')
                    ->label(__('gpms.faculties.status'))
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
            ])->defaultSort('created_at', 'desc');
    }
}
