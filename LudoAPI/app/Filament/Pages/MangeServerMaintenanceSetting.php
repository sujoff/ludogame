<?php

namespace App\Filament\Pages;

use App\Settings\GameSetting;
use App\Settings\ServerMaintenanceSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class MangeServerMaintenanceSetting extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = ServerMaintenanceSetting::class;
    protected static ?string $navigationGroup = 'Settings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Select::make('enable')
                        ->boolean(),
                ]),
                Forms\Components\Section::make()->schema([
                    Forms\Components\DateTimePicker::make('start_date')
                        ->required(),
                    Forms\Components\DateTimePicker::make('end_date')
                        ->required(),
                ])


            ]);
    }
}
