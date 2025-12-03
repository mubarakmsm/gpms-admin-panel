<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Team;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;

class RecentActivity extends TableWidget
{
    protected static ?string $heading = null;
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';
 
    public function table(Table $table): Table
    {
        return $table
        ->recordTitleAttribute('name')
        ->modelLabel(__('gpms.team'))
        ->pluralModelLabel(__('gpms.teams'))
            ->query(fn (): Builder => Team::with(['department.faculty', 'supervisor.user'])
                ->latest()
                ->limit(10)
            )           
            ->columns([
                 TextColumn::make('name')
                ->label(__('gpms.recent_activity.team_name'))
                ->searchable()
                ->sortable()
                ,
                
            TextColumn::make('project_title')
                ->label(__('gpms.recent_activity.project_title'))
                ->searchable(),
            TextColumn::make('department.faculty.name')
                ->label(__('gpms.recent_activity.faculty'))
                ->sortable(),

            TextColumn::make('department.name')
                ->label(__('gpms.recent_activity.department'))
                ->sortable(),

            TextColumn::make('supervisor.user.name')
                ->label(__('gpms.recent_activity.supervisor'))
            ,

            TextColumn::make('status')
                ->label(__('gpms.recent_activity.status'))
                ->colors([
                    'warning' => 'forming',
                    'success' => 'active',
                    'primary' => 'completed',
                    'danger' => 'cancelled',
                ])
                ->formatStateUsing(fn (string $state): string => 
                    match($state) {
                        'forming' => __('gpms.statuses.forming'),
                        'active' => __('gpms.statuses.active'),
                        'completed' => __('gpms.statuses.completed'),
                        'cancelled' => __('gpms.statuses.cancelled'),
                        default => $state
                    }
                ),

            TextColumn::make('progress')
                ->label(__('gpms.recent_activity.progress'))
                ->suffix('%')
                ->sortable(),
            TextColumn::make('created_at')
                ->label(__('gpms.recent_activity.created_at'))
                ->dateTime('Y-m-d H:i')
                ->sortable(),
            ])
            ->filters([
                TrashedFilter::make()
            ])
            ->headerActions([
               
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function getHeading(): string | Htmlable
    {
        return __('gpms.recent_activity.title');
    }
}
