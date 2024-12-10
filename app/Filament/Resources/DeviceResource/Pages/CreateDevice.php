<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use App\Filament\Resources\DeviceResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateDevice extends CreateRecord
{
    protected static string $resource = DeviceResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    public function form(form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->options(User::pluck('name', 'id')->toArray()),
                TextInput::make('device_id'),
                TextInput::make('unique_number'),
                Toggle::make('status')
                    ->inline(false)
                    ->default(true),
            ]);
    }
}
