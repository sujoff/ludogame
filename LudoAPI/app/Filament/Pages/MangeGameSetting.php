<?php

namespace App\Filament\Pages;

use App\Settings\GameSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class MangeGameSetting extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GameSetting::class;
    protected static ?string $navigationGroup = 'Settings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('gems')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('coins')
                    ->numeric()
                    ->required(),
            ]);
    }
}
