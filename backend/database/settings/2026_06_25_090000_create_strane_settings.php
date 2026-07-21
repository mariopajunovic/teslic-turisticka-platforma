<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('strane.kontakt_naslov', ['sr' => 'Kontakt', 'en' => 'Contact', 'de' => 'Kontakt']);
        $this->migrator->add('strane.kontakt_uvod', [
            'sr' => 'Imate pitanje, prijedlog ili želite saradnju? Pošaljite nam poruku ili nas kontaktirajte direktno.',
            'en' => 'Have a question, suggestion or want to collaborate? Send us a message or contact us directly.',
            'de' => 'Haben Sie eine Frage, einen Vorschlag oder möchten Sie zusammenarbeiten? Senden Sie uns eine Nachricht oder kontaktieren Sie uns direkt.',
        ]);
        $this->migrator->add('strane.pridruzi_naslov', ['sr' => 'Pridruži se', 'en' => 'Join us', 'de' => 'Mitmachen']);
        $this->migrator->add('strane.pridruzi_uvod', [
            'sr' => 'Predstavite svoj biznis ili postanite autor priča iz Teslića.',
            'en' => 'Present your business or become an author of stories from Teslić.',
            'de' => 'Präsentieren Sie Ihr Unternehmen oder werden Sie Autor von Geschichten aus Teslić.',
        ]);
        $this->migrator->add('strane.reg_biznis_naslov', ['sr' => 'Registruj biznis', 'en' => 'Register a business', 'de' => 'Unternehmen registrieren']);
        $this->migrator->add('strane.reg_biznis_uvod', [
            'sr' => 'Nakon registracije nalog ide na pregled administratora. Profil i objave uređujete nakon odobrenja.',
            'en' => 'After registration, the account goes to the administrator for review. You edit your profile and posts after approval.',
            'de' => 'Nach der Registrierung geht das Konto zur Überprüfung an den Administrator. Profil und Beiträge bearbeiten Sie nach der Genehmigung.',
        ]);
        $this->migrator->add('strane.reg_autor_naslov', ['sr' => 'Uključi se kao autor', 'en' => 'Join as an author', 'de' => 'Als Autor mitmachen']);
        $this->migrator->add('strane.reg_autor_uvod', [
            'sr' => 'Nakon registracije nalog ide na pregled administratora. Priče kreirate i šaljete na odobrenje nakon prijave.',
            'en' => 'After registration, the account goes to the administrator for review. You create and submit stories for approval after logging in.',
            'de' => 'Nach der Registrierung geht das Konto zur Überprüfung an den Administrator. Geschichten erstellen und zur Genehmigung einreichen Sie nach der Anmeldung.',
        ]);
        $this->migrator->add('strane.prijava_naslov', ['sr' => 'Prijava', 'en' => 'Login', 'de' => 'Anmeldung']);
        $this->migrator->add('strane.registracija_naslov', ['sr' => 'Registracija', 'en' => 'Registration', 'de' => 'Registrierung']);
        $this->migrator->add('strane.registracija_uvod', [
            'sr' => 'Odaberite vrstu naloga koju želite otvoriti.',
            'en' => 'Choose the type of account you want to open.',
            'de' => 'Wählen Sie die Art des Kontos, das Sie eröffnen möchten.',
        ]);
        $this->migrator->add('strane.zaboravljena_naslov', ['sr' => 'Zaboravljena lozinka', 'en' => 'Forgot password', 'de' => 'Passwort vergessen']);
        $this->migrator->add('strane.zaboravljena_uvod', [
            'sr' => 'Unesite e-mail i poslat ćemo vam link za resetovanje lozinke.',
            'en' => 'Enter your email and we will send you a link to reset your password.',
            'de' => 'Geben Sie Ihre E-Mail-Adresse ein und wir senden Ihnen einen Link zum Zurücksetzen Ihres Passworts.',
        ]);
    }
};
