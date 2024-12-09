<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrackingResource\Pages;
use App\Filament\Resources\TrackingResource\RelationManagers;
use App\Models\Tracking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrackingResource extends Resource
{
    protected static ?string $model = Tracking::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTracking::route('/'),
            'create' => Pages\CreateTracking::route('/create'),
            'edit' => Pages\EditTracking::route('/{record}/edit'),
        ];
    }
}
