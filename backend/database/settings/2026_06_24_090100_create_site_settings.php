<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.brand_naziv', ['sr' => 'TO Teslić']);
        $this->migrator->add('site.brand_logo_tekst', ['sr' => 'teslić']);
        $this->migrator->add('site.brand_logo', '');
        $this->migrator->add('site.logo_visina', 40);
        $this->migrator->add('site.seo_opis', ['sr' => 'Digitalna platforma za promociju turizma, domaćih proizvoda i usluga opštine Teslić.']);
        $this->migrator->add('site.footer_opis', ['sr' => 'Zvanična platforma za promociju turističke ponude, lokalnih proizvoda i usluga opštine Teslić.']);
        $this->migrator->add('site.copyright', ['sr' => '© 2026 TO Teslić. Sva prava zadržana.']);
        $this->migrator->add('site.kontakt_adresa', 'Svetog Save 15, 74270 Teslić');
        $this->migrator->add('site.kontakt_telefon', '053/430-058');
        $this->migrator->add('site.kontakt_email', 'turistorg.teslic@gmail.com');
        $this->migrator->add('site.social', [
            ['name' => 'facebook', 'href' => 'https://facebook.com', 'label' => 'Facebook'],
            ['name' => 'instagram', 'href' => 'https://instagram.com', 'label' => 'Instagram'],
            ['name' => 'youtube', 'href' => 'https://youtube.com', 'label' => 'YouTube'],
        ]);
        $this->migrator->add('site.partneri', ['Partner 1', 'Partner 2', 'Partner 3', 'Partner 4']);
        $this->migrator->add('site.partneri_tekst', ['sr' => 'Projekat „Teslić u novom svjetlu" finansira Vlada Švicarske kroz projekat Lokalni ekonomski razvoj u BiH (LER u BiH), koji implementira konzorcijum Caritas Švicarske i NIRAS.']);
        $this->migrator->add('site.google_indeksiranje', true);
        $this->migrator->add('site.odrzavanje', false);
        $this->migrator->add('site.odrzavanje_poruka', 'Sajt je trenutno u pripremi. Uskoro dostupno.');
        $this->migrator->add('site.captcha_site_key', env('TURNSTILE_SITEKEY', ''));
        $this->migrator->add('site.captcha_secret', env('TURNSTILE_SECRET', ''));
        $this->migrator->add('site.google_analytics', '');
    }
};
