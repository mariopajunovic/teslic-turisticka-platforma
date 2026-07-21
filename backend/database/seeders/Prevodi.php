<?php

namespace Database\Seeders;

class Prevodi
{
    public static function labele(): array
    {
        return [
            'Zanatski proizvodi' => ['en' => 'Handicrafts', 'de' => 'Handwerksprodukte'],
            'Domaća hrana i piće' => ['en' => 'Local food and drinks', 'de' => 'Lokale Speisen und Getränke'],
            'Poljoprivreda i domaći proizvodi' => ['en' => 'Agriculture and local produce', 'de' => 'Landwirtschaft und heimische Produkte'],
            'Usluge i servisi' => ['en' => 'Services', 'de' => 'Dienstleistungen'],
            'Restorani' => ['en' => 'Restaurants', 'de' => 'Restaurants'],
            'Kafići i barovi' => ['en' => 'Cafes and bars', 'de' => 'Cafés und Bars'],
            'Smještajni kapaciteti' => ['en' => 'Accommodation', 'de' => 'Unterkünfte'],
            'Seoska domaćinstva' => ['en' => 'Rural households', 'de' => 'Ländliche Haushalte'],
            'Zdravstvo' => ['en' => 'Healthcare', 'de' => 'Gesundheitswesen'],
            'Ljepota i njega' => ['en' => 'Beauty and care', 'de' => 'Schönheit und Pflege'],
            'Zabava i rekreacija' => ['en' => 'Entertainment and recreation', 'de' => 'Unterhaltung und Freizeit'],
            'Trgovina' => ['en' => 'Retail', 'de' => 'Einzelhandel'],
            'Prevoz' => ['en' => 'Transport', 'de' => 'Transport'],
            'Udruženja i klubovi' => ['en' => 'Associations and clubs', 'de' => 'Vereine und Klubs'],

            'Prirodne atrakcije' => ['en' => 'Natural attractions', 'de' => 'Naturattraktionen'],
            'Kulturne manifestacije' => ['en' => 'Cultural events', 'de' => 'Kulturveranstaltungen'],
            'Planine, šume i sela' => ['en' => 'Mountains, forests and villages', 'de' => 'Berge, Wälder und Dörfer'],
            'Gdje odsjesti' => ['en' => 'Where to stay', 'de' => 'Wo übernachten'],
            'Speleologija' => ['en' => 'Speleology', 'de' => 'Höhlenforschung'],
            'Planinarenje' => ['en' => 'Hiking', 'de' => 'Wandern'],
            'Vjerski turizam' => ['en' => 'Religious tourism', 'de' => 'Religiöser Tourismus'],
            'Zdravstveni turizam' => ['en' => 'Health tourism', 'de' => 'Gesundheitstourismus'],
            'Izletišta' => ['en' => 'Excursion sites', 'de' => 'Ausflugsziele'],

            'Domaćini pričaju' => ['en' => "Hosts' stories", 'de' => 'Gastgeber erzählen'],
            'Ljudi i biznisi' => ['en' => 'People and businesses', 'de' => 'Menschen und Unternehmen'],
            'Naša svakodnevica' => ['en' => 'Our everyday life', 'de' => 'Unser Alltag'],
            'Izdvojeno' => ['en' => 'Featured', 'de' => 'Hervorgehoben'],

            'Posao' => ['en' => 'Jobs', 'de' => 'Stellenangebote'],
            'Nekretnine' => ['en' => 'Real estate', 'de' => 'Immobilien'],
            'Javni poziv' => ['en' => 'Public calls', 'de' => 'Öffentliche Aufrufe'],

            'Manifestacije' => ['en' => 'Festivals', 'de' => 'Festivals'],
            'Događaji' => ['en' => 'Events', 'de' => 'Veranstaltungen'],

            'Domaće je najbolje' => ['en' => 'Local is best', 'de' => 'Lokal ist am besten'],
            'Turizam' => ['en' => 'Tourism', 'de' => 'Tourismus'],
            'Manifestacije i događaji' => ['en' => 'Festivals and events', 'de' => 'Festivals und Veranstaltungen'],
            'Oglasi' => ['en' => 'Classifieds', 'de' => 'Kleinanzeigen'],
            'Priče' => ['en' => 'Stories', 'de' => 'Geschichten'],
            'Vijesti' => ['en' => 'News', 'de' => 'Nachrichten'],
            'Javne nabavke' => ['en' => 'Public procurement', 'de' => 'Ausschreibungen'],

            'Mapa' => ['en' => 'Map', 'de' => 'Karte'],
            'Mapa ponude' => ['en' => 'Offer map', 'de' => 'Angebotskarte'],
            'O projektu' => ['en' => 'About the project', 'de' => 'Über das Projekt'],
            'Kontakt' => ['en' => 'Contact', 'de' => 'Kontakt'],
            'Pridruži se' => ['en' => 'Join us', 'de' => 'Mitmachen'],
            'Korisne informacije' => ['en' => 'Useful information', 'de' => 'Nützliche Informationen'],
            'Početna' => ['en' => 'Home', 'de' => 'Startseite'],
            'Politika privatnosti' => ['en' => 'Privacy policy', 'de' => 'Datenschutzrichtlinie'],
            'Politika kolačića' => ['en' => 'Cookie policy', 'de' => 'Cookie-Richtlinie'],
            'Uslovi korištenja' => ['en' => 'Terms of use', 'de' => 'Nutzungsbedingungen'],
            'Ostalo' => ['en' => 'Other', 'de' => 'Sonstiges'],
            'Turistička ponuda, proizvodi i priče' => ['en' => 'Tourist offerings, products and stories', 'de' => 'Touristisches Angebot, Produkte und Geschichten'],
        ];
    }

    public static function tr(string $sr): array
    {
        $m = self::labele()[$sr] ?? [];

        return [
            'sr' => $sr,
            'en' => $m['en'] ?? $sr,
            'de' => $m['de'] ?? $sr,
        ];
    }
}
