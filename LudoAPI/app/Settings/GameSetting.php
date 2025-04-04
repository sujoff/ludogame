<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GameSetting extends Settings
{

    public int $gems;
    public int $coins;

    public static function group(): string
    {
        return 'game';
    }
}
