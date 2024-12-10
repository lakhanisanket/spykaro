<?php

namespace App\Filament\Resources\OptionResource\Pages;

use App\Filament\Resources\OptionResource;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateOption extends CreateRecord
{
    protected static string $resource = OptionResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    public function form(form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('key'),
                TextInput::make('value'),
                Textarea::make('data'),
                Toggle::make('status')
                    ->inline(false)
                    ->default(true),
            ]);
    }
}
