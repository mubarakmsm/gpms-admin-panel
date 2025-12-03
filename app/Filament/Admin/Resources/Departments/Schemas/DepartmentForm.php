<?php

namespace App\Filament\Admin\Resources\Departments\Schemas;

use App\Models\Faculty;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\Operation;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('gpms.sections.basic'))
                    ->schema([
                        Select::make('faculty_id')
                            ->label(__('gpms.departments.faculty'))
                            ->options(Faculty::where('status', 'active')->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->preload(),
                        
                        TextInput::make('name')
                            ->label(__('gpms.departments.name'))
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('name_eng')
                            ->label(__('gpms.departments.name_en'))
                            ->maxLength(255),
                        
                        TextInput::make('dept_head')
                            ->label(__('gpms.departments.head'))
                            ->maxLength(255),
                    ])->columns(2),
                
                Section::make(__('gpms.sections.description'))
                    ->schema([
                        Textarea::make('description')
                            ->label(__('gpms.departments.description'))
                            ->rows(3),
                        
                        Textarea::make('description_eng')
                            ->label(__('gpms.departments.description_en'))
                            ->rows(3),
                    ])->columns(2),
                
                Section::make(__('gpms.sections.status'))
                    ->schema([
                        Select::make('status')
                            ->label(__('gpms.departments.status'))
                            ->options([
                                'active' => __('gpms.statuses.active'),
                                'inactive' => __('gpms.statuses.inactive'),
                            ])
                            ->default('active')
                            ->required(),

                    ]),
                Section::make('الإحصائيات')
                ->visibleOn(Operation::View)
                    ->schema([
                        TextEntry::make('students_count')
                            ->label(__('gpms.departments.students_count'))
                            ->badge()->default(0)
                            ->color('primary'),
                        
                        TextEntry::make('supervisors_count')
                            ->label(__('gpms.departments.supervisors_count'))
                            ->badge()->default(0)
                            ->color('primary'),
                    ])->columns(2),
            
            ]);
    }
}