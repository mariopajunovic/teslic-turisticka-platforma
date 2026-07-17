<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.brand_logo', '');
    }

    public function down(): void
    {
        $this->migrator->delete('site.brand_logo');
    }
};
