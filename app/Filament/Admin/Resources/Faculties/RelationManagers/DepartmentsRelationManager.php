<?php

namespace App\Filament\Admin\Resources\Faculties\RelationManagers;

use App\Filament\Admin\Resources\Departments\DepartmentResource;
use App\Filament\Admin\Resources\Departments\Tables\DepartmentsTable;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'departments';

    
    public function form(Schema $schema): Schema
    {
        return $schema
        ->schema([
            

        ])
        ;
    }

    public function table(Table $table): Table
    {
        
        return $table
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
                    ->sortable()

            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
