<?php

namespace App\Filament\Pages;

use App\Settings\ServerIpSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageServerIpSetting extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';

    protected static string $settings = ServerIpSetting::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('primary')
                        ->ip()
                        ->required(),
                    Forms\Components\Select::make('primary_enable')
                        ->boolean()
                        ->required(),
                ]),
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('secondary')
                        ->ip()
                        ->required(),
                    Forms\Components\Select::make('secondary_enable')
                        ->boolean()
                        ->required(),
                ]),
            ]);
    }
}
