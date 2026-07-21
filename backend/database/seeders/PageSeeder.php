<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $this->page('pocetna', 'Početna', true, 'Turistička ponuda, proizvodi i priče', [
            ['type' => 'hero', 'data' => [
                'variant' => 'slika-pozadina',
                'kicker' => ['sr' => 'Turistička organizacija Teslić', 'en' => 'Tourism Organization of Teslić', 'de' => 'Tourismusorganisation Teslić'],
                'title' => ['sr' => 'Otkrijte Teslić', 'en' => 'Discover Teslić', 'de' => 'Entdecken Sie Teslić'],
                'subtitle' => [
                    'sr' => 'Domaći proizvodi, turistički sadržaji, događaji i autentične priče kraja - na jednom mjestu.',
                    'en' => 'Local products, tourist attractions, events and authentic stories of the region - all in one place.',
                    'de' => 'Heimische Produkte, touristische Inhalte, Veranstaltungen und authentische Geschichten der Region - alles an einem Ort.',
                ],
                'image' => 'https://images.unsplash.com/photo-1574410187921-bca6826880c0?auto=format&fit=crop&w=1600&q=80',
            ]],
            ['type' => 'category_nav', 'data' => ['items' => [
                ['label' => Prevodi::tr('Domaće je najbolje'), 'icon' => 'hrana', 'to' => '/domace-je-najbolje'],
                ['label' => Prevodi::tr('Turizam'), 'icon' => 'priroda', 'to' => '/turizam'],
                ['label' => Prevodi::tr('Događaji'), 'icon' => 'calendar', 'to' => '/dogadjaji'],
                ['label' => Prevodi::tr('Mapa ponude'), 'icon' => 'map-pin', 'to' => '/mapa'],
                ['label' => Prevodi::tr('Priče'), 'icon' => 'book-open', 'to' => '/price'],
                ['label' => Prevodi::tr('Oglasi'), 'icon' => 'briefcase', 'to' => '/oglasi'],
            ]]],
            ['type' => 'card_grid', 'data' => ['naslov' => ['sr' => 'Lokalni proizvodi i usluge', 'en' => 'Local products and services', 'de' => 'Lokale Produkte und Dienstleistungen'], 'resource' => 'business', 'limit' => 4, 'cols' => 4, 'linkText' => ['sr' => 'Vidi sve', 'en' => 'View all', 'de' => 'Alle ansehen'], 'to' => '/domace-je-najbolje']],
            ['type' => 'card_grid', 'data' => ['naslov' => ['sr' => 'Turističke atrakcije', 'en' => 'Tourist attractions', 'de' => 'Touristische Attraktionen'], 'resource' => 'location', 'limit' => 4, 'cols' => 4, 'linkText' => ['sr' => 'Vidi sve', 'en' => 'View all', 'de' => 'Alle ansehen'], 'to' => '/turizam']],
            ['type' => 'map', 'data' => ['naslov' => ['sr' => 'Istraži na mapi', 'en' => 'Explore on the map', 'de' => 'Auf der Karte erkunden'], 'linkText' => ['sr' => 'Otvori mapu', 'en' => 'Open map', 'de' => 'Karte öffnen'], 'to' => '/mapa', 'height' => '480px']],
            ['type' => 'card_grid', 'data' => ['naslov' => ['sr' => 'Nadolazeći događaji', 'en' => 'Upcoming events', 'de' => 'Kommende Veranstaltungen'], 'resource' => 'event', 'limit' => 4, 'cols' => 4, 'linkText' => ['sr' => 'Kalendar', 'en' => 'Calendar', 'de' => 'Kalender'], 'to' => '/dogadjaji']],
            ['type' => 'card_grid', 'data' => ['naslov' => ['sr' => 'Priče iz Teslića', 'en' => 'Stories from Teslić', 'de' => 'Geschichten aus Teslić'], 'resource' => 'story', 'limit' => 3, 'cols' => 3, 'linkText' => ['sr' => 'Sve priče', 'en' => 'All stories', 'de' => 'Alle Geschichten'], 'to' => '/price']],
            ['type' => 'featured_story', 'data' => ['naslov' => ['sr' => 'Izdvojena priča', 'en' => 'Featured story', 'de' => 'Ausgewählte Geschichte']]],
            ['type' => 'stats', 'data' => [
                'settings' => ['background' => 'primary-tint', 'padding' => 'lg'],
                'naslov' => ['sr' => 'Teslić u brojkama', 'en' => 'Teslić in numbers', 'de' => 'Teslić in Zahlen'],
                'items' => [
                    ['value' => '120+', 'label' => ['sr' => 'Registrovanih ponuđača', 'en' => 'Registered providers', 'de' => 'Registrierte Anbieter']],
                    ['value' => '40+', 'label' => ['sr' => 'Turističkih lokaliteta', 'en' => 'Tourist sites', 'de' => 'Touristische Orte']],
                    ['value' => '30+', 'label' => ['sr' => 'Događaja godišnje', 'en' => 'Events per year', 'de' => 'Veranstaltungen pro Jahr']],
                    ['value' => '15.000+', 'label' => ['sr' => 'Posjetilaca mjesečno', 'en' => 'Visitors per month', 'de' => 'Besucher pro Monat']],
                ],
            ]],
            ['type' => 'gallery', 'data' => [
                'naslov' => ['sr' => 'Galerija', 'en' => 'Gallery', 'de' => 'Galerie'],
                'variant' => 'grid',
                'items' => [
                    ['src' => 'https://images.unsplash.com/photo-1652552888460-334e60915994?auto=format&fit=crop&w=1080&q=80', 'alt' => 'Teslić'],
                    ['src' => 'https://images.unsplash.com/photo-1611458182018-c043f4e947ec?auto=format&fit=crop&w=1080&q=80', 'alt' => ['sr' => 'Priroda', 'en' => 'Nature', 'de' => 'Natur']],
                    ['src' => 'https://images.unsplash.com/photo-1654156109213-00399ebbd802?auto=format&fit=crop&w=1080&q=80', 'alt' => 'Banja Vrućica'],
                    ['src' => 'https://images.unsplash.com/photo-1725118345125-3ceaa0599620?auto=format&fit=crop&w=1080&q=80', 'alt' => ['sr' => 'Planine', 'en' => 'Mountains', 'de' => 'Berge']],
                ],
            ]],
            ['type' => 'cta', 'data' => [
                'title' => ['sr' => 'Pokreni svoju priču', 'en' => 'Start your story', 'de' => 'Starten Sie Ihre Geschichte'],
                'text' => [
                    'sr' => 'Registruj biznis ili postani autor i predstavi svoj kraj široj publici.',
                    'en' => 'Register a business or become an author and present your region to a wider audience.',
                    'de' => 'Registrieren Sie ein Unternehmen oder werden Sie Autor und präsentieren Sie Ihre Region einem breiteren Publikum.',
                ],
                'buttons' => [
                    ['label' => ['sr' => 'Registruj biznis', 'en' => 'Register a business', 'de' => 'Unternehmen registrieren'], 'url' => '/pridruzi-se/biznis', 'variant' => 'sekundarna'],
                    ['label' => ['sr' => 'Postani autor', 'en' => 'Become an author', 'de' => 'Autor werden'], 'url' => '/pridruzi-se/autor', 'variant' => 'primary'],
                ],
            ]],
        ]);

        $this->page('pridruzi-se', 'Pridruži se', true, 'Pridruži se', [
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

        $this->page('o-projektu', 'O projektu', false, 'O projektu', [
            ['type' => 'hero', 'data' => ['variant' => 'split', 'kicker' => 'Platforma TO Teslić', 'title' => 'O projektu', 'subtitle' => 'Centralno digitalno mjesto za promociju turističke ponude, lokalnih proizvoda i autentičnih priča Teslića.', 'image' => '']],
            ['type' => 'rich_text', 'data' => ['sadrzaj' => '<p>Platforma okuplja domaću ponudu, turističke sadržaje i priče zajednice na jednom mjestu. Registrovani biznisi, domaćini i autori učestvuju kroz administrativno kontrolisan proces objavljivanja, čime se osigurava kvalitet i vjerodostojnost sadržaja.</p>']],
            ['type' => 'card_grid', 'data' => ['naslov' => 'Izdvojeni biznisi', 'resource' => 'business', 'limit' => 4, 'cols' => 4, 'linkText' => 'Vidi sve', 'to' => '/domace-je-najbolje']],
            ['type' => 'cta', 'data' => ['title' => 'Pridruži se zajednici', 'text' => 'Registruj svoj biznis ili postani autor i podijeli priču svog kraja.', 'buttons' => [['label' => 'Registruj biznis', 'url' => '/pridruzi-se', 'variant' => 'sekundarna']]]],
        ]);

        $this->page('mapa', 'Mapa', true, 'Mapa ponude', [
            ['type' => 'hero', 'data' => ['variant' => 'split', 'kicker' => 'Interaktivna mapa', 'title' => 'Istraži Teslić na mapi', 'subtitle' => 'Turistički lokaliteti, domaći proizvođači, smještaj i događaji - sve na jednom mjestu, filtrirano po vrsti i naselju.', 'image' => '']],
            ['type' => 'map_explorer', 'data' => ['naslov' => 'Ponuda na mapi']],
        ], ['sr' => 'mapa', 'en' => 'map', 'de' => 'karte']);

        $this->page('kontakt', 'Kontakt', true, 'Kontakt', [
            ['type' => 'hero', 'data' => ['variant' => 'split', 'kicker' => 'Turistička organizacija grada Teslića', 'title' => 'Kontakt', 'subtitle' => 'Imate pitanje, prijedlog ili želite saradnju? Pošaljite nam poruku ili nas kontaktirajte direktno.', 'image' => '']],
            ['type' => 'contact_form', 'data' => ['naslov' => 'Pošaljite nam poruku', 'prikaziMapu' => true]],
        ]);

        $this->page('korisne-informacije', 'Korisne informacije', false, 'Korisne informacije', [
            ['type' => 'hero', 'data' => ['variant' => 'split', 'kicker' => 'Za posjetioce', 'title' => 'Korisne informacije', 'subtitle' => 'Praktične informacije za posjetioce Teslića - kontakti, prevoz, radno vrijeme i važni brojevi.', 'image' => '']],
            ['type' => 'rich_text', 'data' => ['sadrzaj' => '<h3>Turistička organizacija grada Teslića</h3><p>Adresa: Svetog Save 15, 74270 Teslić<br>Telefon: 053/430-058<br>E-mail: turistorg.teslic@gmail.com</p><h3>Prevoz</h3><p>Teslić je povezan autobuskim linijama sa većim gradovima u regiji. Autobuska stanica nalazi se u centru grada.</p><h3>Važni brojevi</h3><p>Policija: 122<br>Hitna pomoć: 124<br>Vatrogasci: 123</p>']],
        ]);

        $this->legal('politika-privatnosti', 'Politika privatnosti', 'Politika privatnosti opisuje kako platforma prikuplja, koristi i štiti lične podatke korisnika u skladu s važećim propisima.');
        $this->legal('politika-kolacica', 'Politika kolačića', 'Platforma koristi kolačiće radi osnovne funkcionalnosti i poboljšanja korisničkog iskustva. Korisnik može upravljati saglasnošću za kolačiće.');
        $this->legal('uslovi-koristenja', 'Uslovi korištenja', 'Korištenjem platforme korisnik prihvata uslove korištenja, uključujući pravila objavljivanja sadržaja i odgovornosti.');
    }

    protected function legal(string $slug, string $title, string $tekst): void
    {
        $this->page($slug, $title, false, $title, [
            ['type' => 'hero', 'data' => ['variant' => 'split', 'title' => $title, 'subtitle' => '', 'image' => '']],
            ['type' => 'rich_text', 'data' => ['sadrzaj' => '<p>'.$tekst.'</p>']],
        ]);
    }

    protected function page(string $slug, string $title, bool $isSystem, string $metaTitle, array $content, ?array $slugMap = null): void
    {
        $page = Page::where('slug->sr', $slug)->first() ?? new Page();

        $page->fill([
            'published' => true,
            'is_system' => $isSystem,
            'content' => $content,
        ]);

        $page->setTranslations('title', Prevodi::tr($title));
        $page->setTranslations('meta_title', Prevodi::tr($metaTitle));
        $page->slug = $slugMap ?? ['sr' => $slug];
        $page->save();
    }
}
