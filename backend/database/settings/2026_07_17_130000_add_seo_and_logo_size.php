<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.seo_opis', 'Digitalna platforma za promociju turizma, domaćih proizvoda i usluga opštine Teslić.');
        $this->migrator->add('site.logo_visina', 40);
    }

    public function down(): void
    {
        $this->migrator->delete('site.seo_opis');
        $this->migrator->delete('site.logo_visina');
    }
};
