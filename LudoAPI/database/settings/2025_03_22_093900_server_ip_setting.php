<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('server_ip.primary_enable', true);
        $this->migrator->add('server_ip.secondary_enable', false);
    }
};
