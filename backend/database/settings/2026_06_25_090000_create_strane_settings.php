<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('strane.kontakt_naslov', 'Kontakt');
        $this->migrator->add('strane.kontakt_uvod', 'Imate pitanje, prijedlog ili želite saradnju? Pošaljite nam poruku ili nas kontaktirajte direktno.');
        $this->migrator->add('strane.pridruzi_naslov', 'Pridruži se');
        $this->migrator->add('strane.pridruzi_uvod', 'Predstavite svoj biznis ili postanite autor priča iz Teslića.');
        $this->migrator->add('strane.reg_biznis_naslov', 'Registruj biznis');
        $this->migrator->add('strane.reg_biznis_uvod', 'Nakon registracije nalog ide na pregled administratora. Profil i objave uređujete nakon odobrenja.');
        $this->migrator->add('strane.reg_autor_naslov', 'Uključi se kao autor');
        $this->migrator->add('strane.reg_autor_uvod', 'Nakon registracije nalog ide na pregled administratora. Priče kreirate i šaljete na odobrenje nakon prijave.');
        $this->migrator->add('strane.prijava_naslov', 'Prijava');
        $this->migrator->add('strane.registracija_naslov', 'Registracija');
        $this->migrator->add('strane.registracija_uvod', 'Odaberite vrstu naloga koju želite otvoriti.');
        $this->migrator->add('strane.zaboravljena_naslov', 'Zaboravljena lozinka');
        $this->migrator->add('strane.zaboravljena_uvod', 'Unesite e-mail i poslat ćemo vam link za resetovanje lozinke.');
    }
};
