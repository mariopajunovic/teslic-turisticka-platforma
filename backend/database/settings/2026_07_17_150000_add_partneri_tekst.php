<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add(
            'site.partneri_tekst',
            'Projekat „Teslić u novom svjetlu" finansira Vlada Švicarske kroz projekat Lokalni ekonomski razvoj u BiH (LER u BiH), koji implementira konzorcijum Caritas Švicarske i NIRAS.'
        );
    }

    public function down(): void
    {
        $this->migrator->delete('site.partneri_tekst');
    }
};
