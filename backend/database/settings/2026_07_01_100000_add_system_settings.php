<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.google_indeksiranje', true);
        $this->migrator->add('site.odrzavanje', false);
        $this->migrator->add('site.odrzavanje_lozinka', 'teslic2026');
        $this->migrator->add('site.odrzavanje_minuta', 120);
        $this->migrator->add('site.odrzavanje_poruka', 'Sajt je trenutno u pripremi. Uskoro dostupno.');
    }

    public function down(): void
    {
        $this->migrator->delete('site.google_indeksiranje');
        $this->migrator->delete('site.odrzavanje');
        $this->migrator->delete('site.odrzavanje_lozinka');
        $this->migrator->delete('site.odrzavanje_minuta');
        $this->migrator->delete('site.odrzavanje_poruka');
    }
};
