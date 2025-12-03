<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الحساب')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->label(__('gpms.common.full_name'))
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('email')
                            ->label(__('gpms.users.email'))
                            ->email()
                            ->unique()
                            ->validationMessages([
                                'unique' => 'هذا الحساب موجود بالفعل!'
                            ])
                            ->required(),
                        TextInput::make('phone')
                            ->label(__('gpms.users.phone'))
                            ->tel()
                            ->validationMessages([
                                'starts_with' => 'يجب ان يبدا الرقم بـ[ 77, 78, 71, 73, 70 ]'
                            ])
                            ->startsWith([77, 78, 73, 71, 70])
                            ->maxLength(15)
                            ->minLength(9)
                            ->default(null),
                        FileUpload::make('avatar')
                            ->label(__('gpms.users.avatar'))
                            ->columnSpanFull()
                            ->image()
                            ->disk('public')
                            ->directory('avatars'),
                    ]),
                ])->description('معلومات أساسية عن المستخدم'),

                Section::make('الأمان')
                    ->description('إعدادات الأمان وكلمة المرور')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('password')
                                ->label(__('gpms.common.password'))
                                ->password()
                                // ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                ->dehydrated(fn(?string $state): bool => filled($state))
                                ->minLength(8)
                                ->revealable()
                                ->required(fn(string $operation): bool => $operation == Operation::Create)
                                ->columnSpan(2)
                                ->live(onBlur:true),
                            TextInput::make('password_confirmation')
                                ->label(__('gpms.common.confirm_password'))
                                ->password()
                                ->revealable()
                                ->same('password')
                                ->validationMessages([
                                    'same' => 'كملة المرور غير مطابقة',
                                ])
                                ->columnSpan(2),
                            Select::make('role')
                            ->hidden()
                                ->label(__('gpms.users.role'))
                                ->options([
                                    'student' => 'طالب',
                                    'supervisor' => 'مشرف',
                                    'admin' => 'مدير',
                                    'super_admin' => 'مشرف عام',
                                ])
                            
                                
                        ]),
                    ]),




            ]);
    }
}
