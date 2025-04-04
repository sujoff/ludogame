<?php

namespace App\Filament\Pages;

use App\Settings\RewardSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageReward extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';

    protected static string $settings = RewardSetting::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cycle')
                    ->numeric()
                    ->required()
            ]);
    }
}
