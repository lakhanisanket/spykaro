<?php

namespace App\Filament\Resources\TrackingResource\Pages;

use App\Filament\Resources\TrackingResource;
use App\Models\Tracking;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditTracking extends EditRecord
{
    protected static string $resource = TrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

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
                Select::make('type')
                    ->options(Tracking::TYPE_SELECT),
                SpatieMediaLibraryFileUpload::make('file')
                    ->collection('tracking_file')
                    ->image()
                    ->conversion('thumb')
                    ->columnSpanFull(),
                Textarea::make('data')
            ]);
    }
}
