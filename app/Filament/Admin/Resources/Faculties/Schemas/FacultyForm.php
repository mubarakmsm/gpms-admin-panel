<?php

namespace App\Filament\Admin\Resources\Faculties\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class FacultyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('gpms.sections.basic'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('gpms.faculties.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name_eng')
                            ->label(__('gpms.faculties.name_en'))
                            ->maxLength(255),
                        TextInput::make('dean_name')
                            ->label(__('gpms.faculties.dean'))
                            ->maxLength(255),
                    ])->columns(2),
                
                Section::make(__('gpms.sections.description'))
                    ->schema([
                        Textarea::make('description')
                            ->label(__('gpms.faculties.description'))
                            ->rows(3),
                        Textarea::make('description_eng')
                            ->label(__('gpms.faculties.description_en'))
                            ->rows(3),
                    ])->columns(2),
                
                Section::make(__('gpms.sections.status'))
                    ->schema([
                        Select::make('status')
                            ->label(__('gpms.faculties.status'))
                            ->options([
                                'active' => __('gpms.statuses.active'),
                                'inactive' => __('gpms.statuses.inactive'),
                            ])
                            ->default('active')
                            ->required(),
                    ]),
            ]);
    }

    
}
