<?php

namespace App\Filament\Admin\Resources\Departments;

use App\Filament\Admin\Resources\Departments\Pages\CreateDepartment;
use App\Filament\Admin\Resources\Departments\Pages\EditDepartment;
use App\Filament\Admin\Resources\Departments\Pages\ListDepartments;
use App\Filament\Admin\Resources\Departments\Pages\ViewDepartment;
use App\Filament\Admin\Resources\Departments\RelationManagers\StudentsRelationManager;
use App\Filament\Admin\Resources\Departments\RelationManagers\SupervisorsRelationManager;
use App\Filament\Admin\Resources\Departments\Schemas\DepartmentForm;
use App\Filament\Admin\Resources\Departments\Schemas\DepartmentInfolist;
use App\Filament\Admin\Resources\Departments\Tables\DepartmentsTable;
use App\Models\Department;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;
    
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::RectangleGroup;
    protected static string|UnitEnum|null $navigationGroup = null;
    protected static ?string $navigationLabel = null;
    protected static ?string $pluralModelLabel = null;
    protected static ?string $modelLabel = null;
    protected static int|null $navigationSort =2;

    protected static ?string $recordTitleAttribute = 'name';
    
    

    public static function form(Schema $schema): Schema
    {
        return DepartmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DepartmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class,
            SupervisorsRelationManager::class,
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('gpms.departments.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('gpms.departments.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('gpms.departments.plural');
    }

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return __('gpms.departments.navigation_group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDepartments::route('/'),
            'create' => CreateDepartment::route('/create'),
            'view' => ViewDepartment::route('/{record}'),
            'edit' => EditDepartment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}