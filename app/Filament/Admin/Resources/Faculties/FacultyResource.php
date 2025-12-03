<?php

namespace App\Filament\Admin\Resources\Faculties;

use App\Filament\Admin\Resources\Faculties\Pages\CreateFaculty;
use App\Filament\Admin\Resources\Faculties\Pages\EditFaculty;
use App\Filament\Admin\Resources\Faculties\Pages\ListFaculties;
use App\Filament\Admin\Resources\Faculties\Pages\ViewFaculty;
use App\Filament\Admin\Resources\Faculties\Schemas\FacultyForm;
use App\Filament\Admin\Resources\Faculties\Schemas\FacultyInfolist;
use App\Filament\Admin\Resources\Faculties\Tables\FacultiesTable;
use App\Filament\Admin\Resources\Faculties\RelationManagers\DepartmentsRelationManager;
use App\Models\Faculty;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class FacultyResource extends Resource
{
    protected static ?string $model = Faculty::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::BuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = null;
    protected static ?string $navigationLabel = null;
    protected static ?string $pluralModelLabel = null;
    protected static ?string $modelLabel = null;
    protected static int|null $navigationSort = 1;

    // protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return FacultyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FacultyInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FacultiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [

             DepartmentsRelationManager::class,
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('gpms.faculties.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('gpms.faculties.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('gpms.faculties.plural');
    }

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return __('gpms.faculties.navigation_group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFaculties::route('/'),
            // 'create' => CreateFaculty::route('/create'),
            'view' => ViewFaculty::route('/{record}'),
            'edit' => EditFaculty::route('/{record}/edit'),
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
