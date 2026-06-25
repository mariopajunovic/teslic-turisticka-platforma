<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $this->page('pocetna', 'Početna', true, 'TO Teslić — turistička ponuda, proizvodi i priče', [
            ['type' => 'hero', 'data' => [
                'variant' => 'slika-pozadina',
                'kicker' => 'Turistička organizacija Teslić',
                'title' => 'Otkrijte Teslić',
                'subtitle' => 'Domaći proizvodi, turistički sadržaji, događaji i autentične priče kraja — na jednom mjestu.',
                'image' => 'https://images.unsplash.com/photo-1574410187921-bca6826880c0?auto=format&fit=crop&w=1600&q=80',
            ]],
            ['type' => 'category_nav', 'data' => ['items' => [
                ['label' => 'Domaće je najbolje', 'icon' => 'hrana', 'to' => '/domace-je-najbolje'],
                ['label' => 'Turizam', 'icon' => 'priroda', 'to' => '/turizam'],
                ['label' => 'Događaji', 'icon' => 'calendar', 'to' => '/dogadjaji'],
                ['label' => 'Mapa ponude', 'icon' => 'map-pin', 'to' => '/mapa'],
                ['label' => 'Priče', 'icon' => 'book-open', 'to' => '/price'],
                ['label' => 'Oglasi', 'icon' => 'briefcase', 'to' => '/oglasi'],
            ]]],
            ['type' => 'card_grid', 'data' => ['naslov' => 'Lokalni proizvodi i usluge', 'resource' => 'business', 'limit' => 4, 'cols' => 4, 'linkText' => 'Vidi sve', 'to' => '/domace-je-najbolje']],
            ['type' => 'card_grid', 'data' => ['naslov' => 'Turističke atrakcije', 'resource' => 'location', 'limit' => 4, 'cols' => 4, 'linkText' => 'Vidi sve', 'to' => '/turizam']],
            ['type' => 'map', 'data' => ['naslov' => 'Istraži na mapi', 'linkText' => 'Otvori mapu', 'to' => '/mapa', 'height' => '480px']],
            ['type' => 'card_grid', 'data' => ['naslov' => 'Nadolazeći događaji', 'resource' => 'event', 'limit' => 4, 'cols' => 4, 'linkText' => 'Kalendar', 'to' => '/dogadjaji']],
            ['type' => 'card_grid', 'data' => ['naslov' => 'Priče iz Teslića', 'resource' => 'story', 'limit' => 3, 'cols' => 3, 'linkText' => 'Sve priče', 'to' => '/price']],
            ['type' => 'featured_story', 'data' => ['naslov' => 'Izdvojena priča']],
            ['type' => 'stats', 'data' => [
                'settings' => ['background' => 'primary-tint', 'padding' => 'lg'],
                'naslov' => 'Teslić u brojkama',
                'items' => [
                    ['value' => '120+', 'label' => 'Registrovanih ponuđača'],
                    ['value' => '40+', 'label' => 'Turističkih lokaliteta'],
                    ['value' => '30+', 'label' => 'Događaja godišnje'],
                    ['value' => '15.000+', 'label' => 'Posjetilaca mjesečno'],
                ],
            ]],
            ['type' => 'gallery', 'data' => [
                'naslov' => 'Galerija',
                'variant' => 'grid',
                'items' => [
                    ['src' => 'https://images.unsplash.com/photo-1652552888460-334e60915994?auto=format&fit=crop&w=1080&q=80', 'alt' => 'Teslić'],
                    ['src' => 'https://images.unsplash.com/photo-1611458182018-c043f4e947ec?auto=format&fit=crop&w=1080&q=80', 'alt' => 'Priroda'],
                    ['src' => 'https://images.unsplash.com/photo-1654156109213-00399ebbd802?auto=format&fit=crop&w=1080&q=80', 'alt' => 'Banja Vrućica'],
                    ['src' => 'https://images.unsplash.com/photo-1725118345125-3ceaa0599620?auto=format&fit=crop&w=1080&q=80', 'alt' => 'Planine'],
                ],
            ]],
            ['type' => 'cta', 'data' => [
                'title' => 'Pokreni svoju priču',
                'text' => 'Registruj biznis ili postani autor i predstavi svoj kraj široj publici.',
                'buttons' => [
                    ['label' => 'Registruj biznis', 'url' => '/pridruzi-se/biznis', 'variant' => 'sekundarna'],
                    ['label' => 'Postani autor', 'url' => '/pridruzi-se/autor', 'variant' => 'primary'],
                ],
            ]],
        ]);

        $this->page('pridruzi-se', 'Pridruži se', true, 'Pridruži se — TO Teslić', [
            ['type' => 'hero', 'data' => [
                'variant' => 'slika-pozadina',
                'kicker' => 'Postani dio platforme',
                'title' => 'Pridruži se zajednici Teslića',
                'subtitle' => 'Predstavi svoj biznis hiljadama posjetilaca ili podijeli priču o teslićkom kraju.',
                'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1600&q=80',
            ]],
            ['type' => 'cta', 'data' => [
                'settings' => ['background' => 'surface-alt', 'padding' => 'lg'],
                'title' => 'Odaberi svoju putanju',
                'text' => 'Registruj biznis i budi vidljiv u lokalnoj ponudi, ili se uključi kao autor i piši priče kraja.',
                'buttons' => [
                    ['label' => 'Registruj biznis', 'url' => '/pridruzi-se/biznis', 'variant' => 'sekundarna'],
                    ['label' => 'Uključi se kao autor', 'url' => '/pridruzi-se/autor', 'variant' => 'primary'],
                ],
            ]],
            ['type' => 'stats', 'data' => [
                'naslov' => 'Zašto se pridružiti',
                'items' => [
                    ['value' => '15.000+', 'label' => 'Posjetilaca mjesečno'],
                    ['value' => 'Besplatno', 'label' => 'Osnovni profil'],
                    ['value' => 'SEO', 'label' => 'Vidljivost na pretraživačima'],
                    ['value' => 'Podrška', 'label' => 'Pomoć pri postavljanju'],
                ],
            ]],
            ['type' => 'stepper', 'data' => [
                'settings' => ['background' => 'surface-alt', 'padding' => 'lg'],
                'naslov' => 'Kako funkcioniše',
                'steps' => [
                    ['title' => 'Registruj nalog', 'text' => 'Odaberi biznis ili autor i popuni osnovne podatke.'],
                    ['title' => 'Postavi sadržaj', 'text' => 'Dodaj opis, fotografije i kontakt informacije.'],
                    ['title' => 'Pošalji na pregled', 'text' => 'Tim turističke organizacije pregleda i odobrava sadržaj.'],
                    ['title' => 'Objavljeno', 'text' => 'Tvoj sadržaj je vidljiv svim posjetiocima platforme.'],
                ],
            ]],
            ['type' => 'faq', 'data' => [
                'naslov' => 'Česta pitanja',
                'items' => [
                    ['q' => 'Da li je registracija besplatna?', 'a' => 'Da, osnovni profil i objavljivanje sadržaja su besplatni za lokalne ponuđače i autore.'],
                    ['q' => 'Ko odobrava sadržaj?', 'a' => 'Sav sadržaj prije objave pregleda tim Turističke organizacije Teslić radi osiguranja kvaliteta.'],
                    ['q' => 'Mogu li uređivati objavu nakon objavljivanja?', 'a' => 'Da, izmjene su moguće kroz vaš nalog, a veće promjene ponovo prolaze kratak pregled.'],
                ],
            ]],
            ['type' => 'partners', 'data' => [
                'naslov' => 'Partneri i podrška',
                'items' => [
                    ['name' => 'Opština Teslić', 'logo' => '', 'url' => ''],
                    ['name' => 'TO Republike Srpske', 'logo' => '', 'url' => ''],
                    ['name' => 'Banja Vrućica', 'logo' => '', 'url' => ''],
                    ['name' => 'Privredna komora', 'logo' => '', 'url' => ''],
                ],
            ]],
            ['type' => 'cta', 'data' => [
                'settings' => ['background' => 'primary', 'padding' => 'lg'],
                'title' => 'Spreman/na za početak?',
                'text' => 'Kreiraj nalog za par minuta i predstavi svoj kraj.',
                'buttons' => [
                    ['label' => 'Kreiraj nalog', 'url' => '/registracija', 'variant' => 'sekundarna'],
                ],
            ]],
        ]);

        $this->page('o-projektu', 'O projektu', false, 'O projektu — TO Teslić', [
            ['type' => 'hero', 'data' => ['variant' => 'split', 'kicker' => 'Platforma TO Teslić', 'title' => 'O projektu', 'subtitle' => 'Centralno digitalno mjesto za promociju turističke ponude, lokalnih proizvoda i autentičnih priča Teslića.', 'image' => '']],
            ['type' => 'rich_text', 'data' => ['sadrzaj' => '<p>Platforma okuplja domaću ponudu, turističke sadržaje i priče zajednice na jednom mjestu. Registrovani biznisi, domaćini i autori učestvuju kroz administrativno kontrolisan proces objavljivanja, čime se osigurava kvalitet i vjerodostojnost sadržaja.</p>']],
            ['type' => 'card_grid', 'data' => ['naslov' => 'Izdvojeni biznisi', 'resource' => 'business', 'limit' => 4, 'cols' => 4, 'linkText' => 'Vidi sve', 'to' => '/domace-je-najbolje']],
            ['type' => 'cta', 'data' => ['title' => 'Pridruži se zajednici', 'text' => 'Registruj svoj biznis ili postani autor i podijeli priču svog kraja.', 'buttons' => [['label' => 'Registruj biznis', 'url' => '/pridruzi-se', 'variant' => 'sekundarna']]]],
        ]);

        $this->legal('politika-privatnosti', 'Politika privatnosti', 'Politika privatnosti opisuje kako platforma prikuplja, koristi i štiti lične podatke korisnika u skladu s važećim propisima.');
        $this->legal('politika-kolacica', 'Politika kolačića', 'Platforma koristi kolačiće radi osnovne funkcionalnosti i poboljšanja korisničkog iskustva. Korisnik može upravljati saglasnošću za kolačiće.');
        $this->legal('uslovi-koristenja', 'Uslovi korištenja', 'Korištenjem platforme korisnik prihvata uslove korištenja, uključujući pravila objavljivanja sadržaja i odgovornosti.');
    }

    protected function legal(string $slug, string $title, string $tekst): void
    {
        $this->page($slug, $title, false, $title.' — TO Teslić', [
            ['type' => 'hero', 'data' => ['variant' => 'split', 'title' => $title, 'subtitle' => '', 'image' => '']],
            ['type' => 'rich_text', 'data' => ['sadrzaj' => '<p>'.$tekst.'</p>']],
        ]);
    }

    protected function page(string $slug, string $title, bool $isSystem, string $metaTitle, array $content): void
    {
        Page::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $title,
                'published' => true,
                'is_system' => $isSystem,
                'meta_title' => $metaTitle,
                'content' => $content,
            ],
        );
    }
}
