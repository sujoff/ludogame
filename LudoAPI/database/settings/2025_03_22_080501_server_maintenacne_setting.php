<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('server_maintenance.enable', false);
        $this->migrator->add('server_maintenance.start_date', null);
        $this->migrator->add('server_maintenance.end_date', null);
    }
};
