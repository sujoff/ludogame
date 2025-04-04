<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ServerIpSetting extends Settings
{
    public $primary;
    public $primary_enable;

    public $secondary;
    public $secondary_enable;


    public static function group(): string
    {
        return 'server_ip';
    }
}
