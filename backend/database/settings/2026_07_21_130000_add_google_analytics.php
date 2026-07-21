<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.google_analytics', '');
    }

    public function down(): void
    {
        $this->migrator->delete('site.google_analytics');
    }
};
