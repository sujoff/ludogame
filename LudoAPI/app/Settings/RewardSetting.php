<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class RewardSetting extends Settings
{

    public $cycle;

    public static function group(): string
    {
        return 'reward';
    }
}
