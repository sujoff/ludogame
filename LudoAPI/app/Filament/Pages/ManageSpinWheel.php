<?php

namespace App\Filament\Pages;

use App\Settings\SpinWheelSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageSpinWheel extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static string $settings = SpinWheelSetting::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ad_time_interval')
                    ->label('Ad time interval')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('normal_time_interval')
                    ->label('Normal time interval')
                    ->numeric()
                    ->required(),
            ]);
    }
}
