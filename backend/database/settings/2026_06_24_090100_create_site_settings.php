<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.brand_naziv', 'TO Teslić');
        $this->migrator->add('site.brand_logo_tekst', 'teslić');
        $this->migrator->add('site.footer_opis', 'Zvanična platforma za promociju turističke ponude, lokalnih proizvoda i usluga opštine Teslić.');
        $this->migrator->add('site.copyright', '© 2026 TO Teslić. Sva prava zadržana.');
        $this->migrator->add('site.kontakt_adresa', 'Svetog Save 15, 74270 Teslić');
        $this->migrator->add('site.kontakt_telefon', '053/430-058');
        $this->migrator->add('site.kontakt_email', 'turistorg.teslic@gmail.com');
        $this->migrator->add('site.social', [
            ['name' => 'facebook', 'href' => 'https://facebook.com', 'label' => 'Facebook'],
            ['name' => 'instagram', 'href' => 'https://instagram.com', 'label' => 'Instagram'],
            ['name' => 'youtube', 'href' => 'https://youtube.com', 'label' => 'YouTube'],
        ]);
        $this->migrator->add('site.partneri', ['Partner 1', 'Partner 2', 'Partner 3', 'Partner 4']);
    }
};
