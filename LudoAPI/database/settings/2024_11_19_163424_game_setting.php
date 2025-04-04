<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('game.gems', 1000);
        $this->migrator->add('game.coins', 1000);
    }
};
