<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->delete('site.odrzavanje_lozinka');
        $this->migrator->delete('site.odrzavanje_minuta');
    }

    public function down(): void
    {
        $this->migrator->add('site.odrzavanje_lozinka', 'teslic2026');
        $this->migrator->add('site.odrzavanje_minuta', 120);
    }
};
