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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Container\Attributes\Auth as AttributesAuth;

use function Symfony\Component\Clock\now;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';
    protected static ?string $title = null;
    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;

    public function form(Schema $schema): Schema
    {
        return  $schema
            ->components([
                Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->label(__('gpms.students.user'))
                ->required()
                ->unique()
                ->validationMessages([
                    'unique' => 'هذا المستخدم مرتبط بالفعل بطالب آخر.',
                ]),
                TextInput::make('student_number')
                    ->label(__('gpms.students.student_number'))
                    ->required()
                    ->unique()
                    ->maxLength(255),

                TextInput::make('academic_year')
                    ->label(__('gpms.students.academic_year'))
                    ->required()
                    ->default(date('Y') . '-' . date('Y'))
                    ->maxLength(255),

                Select::make('status')
                    ->label(__('gpms.students.status'))
                    ->options([
                        'active' => __('gpms.statuses.active'),
                        'graduated' => __('gpms.statuses.graduated'),
                        'transferred' => __('gpms.statuses.transferred'),
                        'suspended' => __('gpms.statuses.suspended'),
                    ])
                    ->default('active')
                    ->required(),

                Textarea::make('notes')
                    ->label(__('gpms.students.notes'))
                    ->rows(3),
            ]);
    }

   

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('gpms.students.title');
    }

    public static function getModelLabel(): string
    {
        return __('gpms.students.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('gpms.students.plural');
    }

    // public function infolist(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             // TextEntry::make('name'),
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([

                TextColumn::make('student_number')
                    ->label(__('gpms.students.student_number'))
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label(__('gpms.users.name'))
                    ->searchable(),

                TextColumn::make('academic_year')
                    ->label(__('gpms.students.academic_year'))
                    ->searchable(),

                TextColumn::make('status')
                    ->label(__('gpms.students.status'))
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'primary' => 'graduated',
                        'warning' => 'transferred',
                        'danger' => 'suspended',
                    ])
                    ->formatStateUsing(
                        fn(string $state): string =>
                        match ($state) {
                            'active' => __('gpms.statuses.active'),
                            'graduated' => __('gpms.statuses.graduated'),
                            'transferred' => __('gpms.statuses.transferred'),
                            'suspended' => __('gpms.statuses.suspended'),
                            default => $state
                        }
                    ),

                TextColumn::make('created_at')
                    ->label(__('gpms.students.created_at'))
                    ->dateTime('Y-m-d'),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('status')
                    ->label(__('gpms.students.status'))
                    ->default('active')
                    ->options([
                        'active' => __('gpms.statuses.active'),
                        'graduated' => __('gpms.statuses.graduated'),
                        'transferred' => __('gpms.statuses.transferred'),
                        'suspended' => __('gpms.statuses.suspended'),
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
                    DissociateBulkAction::make(),
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
