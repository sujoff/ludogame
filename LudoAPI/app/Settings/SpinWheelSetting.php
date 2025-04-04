<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SpinWheelSetting extends Settings
{
    public $ad_time_interval;
    public $normal_time_interval;

    public static function group(): string
    {
        return 'spin_wheel';
    }
}
