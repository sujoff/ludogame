<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('spin_wheel.ad_time_interval', 300);
        $this->migrator->add('spin_wheel.normal_time_interval', 86400);
    }
};
