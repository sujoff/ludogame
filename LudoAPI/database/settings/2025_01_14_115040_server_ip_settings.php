<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('server_ip.primary', '127.0.0.1');
        $this->migrator->add('server_ip.secondary', '127.0.0.1');
    }
};
