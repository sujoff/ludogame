<?php

namespace App\Settings;
use Spatie\LaravelSettings\Settings;

class ServerMaintenanceSetting extends Settings
{
    public bool $enable;
    public $start_date;
    public $end_date;

    public static function group(): string
    {
        return 'server_maintenance';
    }
}
