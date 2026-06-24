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
            ['type' => 'cta', 'data' => [
                'title' => 'Pokreni svoju priču',
                'text' => 'Registruj biznis ili postani autor i predstavi svoj kraj široj publici.',
                'buttons' => [
                    ['label' => 'Registruj biznis', 'url' => '/pridruzi-se/biznis', 'variant' => 'sekundarna'],
                    ['label' => 'Postani autor', 'url' => '/pridruzi-se/autor', 'variant' => 'primary'],
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
