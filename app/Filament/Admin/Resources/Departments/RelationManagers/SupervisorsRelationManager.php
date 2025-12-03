<?php

namespace App\Filament\Admin\Resources\Departments\RelationManagers;

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
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class SupervisorsRelationManager extends RelationManager
{
    protected static string $relationship = 'supervisors';

    protected static ?string $title = null;
    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Basic information
                Section::make(__('gpms.sections.basic'))
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label(__('gpms.supervisors.user'))
                            ->required(),

                        TextInput::make('specialization')
                            ->label(__('gpms.supervisors.specialization'))
                            ->maxLength(255),

                        TextInput::make('academic_rank')
                            ->label(__('gpms.supervisors.academic_degree'))
                            ->maxLength(255),

                        TextInput::make('max_projects')
                            ->label(__('gpms.supervisors.max_projects'))
                            ->numeric()
                            ->default(1),
                    ])->columns(2),

                Section::make(__('gpms.sections.description'))
                    ->schema([
                        Textarea::make('expertise_areas')
                            ->label(__('gpms.supervisors.expertise_areas'))
                            ->rows(3),

                        Textarea::make('bio')
                            ->label(__('gpms.supervisors.bio'))
                            ->rows(4),
                    ])->columns(1),

                    Section::make(__('gpms.sections.status'))
                    ->schema([
                        Select::make('status')
                                ->label(__('gpms.supervisors.status'))
                            ->options([
                                'active' => __('gpms.statuses.active'),
                                'inactive' => __('gpms.statuses.inactive'),
                            ])
                            ->default('active')
                            ->required(),
                    ]),
            ]);
    }

     public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('gpms.supervisors.title');
    }

    public static function getModelLabel(): string
    {
        return __('gpms.supervisors.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('gpms.supervisors.plural');
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Could add summary entries here if needed
                // e.g., TextEntry::make('current_projects')->label('مشاريع حالية')->badge(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('gpms.supervisors.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.email')
                    ->label(__('gpms.supervisors.email'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.phone')
                    ->label(__('gpms.supervisors.phone'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('gpms.supervisors.status'))
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->formatStateUsing(fn (string $state): string =>
                        $state === 'active' ? __('gpms.statuses.active') : __('gpms.statuses.inactive')
                    ),

                TextColumn::make('created_at')
                    ->label(__('gpms.supervisors.created_at'))
                    ->dateTime('Y-m-d')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('status')
                    ->label(__('gpms.supervisors.status'))
                    ->options([
                        'active' => __('gpms.statuses.active'),
                        'inactive' => __('gpms.statuses.inactive'),
                    ]),
            ])
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
