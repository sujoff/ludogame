<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpinWheelResource\Pages;
use App\Filament\Resources\SpinWheelResource\RelationManagers;
use App\Models\SpinWheel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn, TextInputColumn};
use Filament\Tables\Table;

class SpinWheelResource extends Resource
{
    protected static ?string $model = SpinWheel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Select::make('collection_id')
                        ->relationship('collection', 'code')
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('collection.code')->sortable(),
                TextInputColumn::make('index')->sortable(),
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
            'index' => Pages\ListSpinWheels::route('/'),
            'create' => Pages\CreateSpinWheel::route('/create'),
            'edit' => Pages\EditSpinWheel::route('/{record}/edit'),
        ];
    }
}
