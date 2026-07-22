<?php

namespace App\Support;

class BlockSchema
{
    /**
     * Jedinstveni izvor istine za blokove stranica.
     * Svako polje: name, label, type (text|textarea|richtext|image|url|number|select|toggle|repeater),
     * tr (prevodivo), required, options (za select), fields (za repeater).
     */
    public static function all(): array
    {
        return [
            'hero' => ['label' => 'Hero', 'icon' => 'panel-top', 'opis' => 'Naslovna sekcija sa slikom', 'fields' => [
                ['name' => 'kicker', 'label' => 'Nadnaslov', 'type' => 'text', 'tr' => true],
                ['name' => 'title', 'label' => 'Naslov', 'type' => 'text', 'tr' => true, 'required' => true],
                ['name' => 'subtitle', 'label' => 'Podnaslov', 'type' => 'textarea', 'tr' => true],
                ['name' => 'image', 'label' => 'Slika', 'type' => 'image'],
                ['name' => 'variant', 'label' => 'Varijanta', 'type' => 'select', 'options' => ['split' => 'Split', 'slika-pozadina' => 'Slika u pozadini']],
            ]],
            'section_header' => ['label' => 'Naslov sekcije', 'icon' => 'heading', 'opis' => 'Naslov + link', 'fields' => [
                ['name' => 'title', 'label' => 'Naslov', 'type' => 'text', 'tr' => true, 'required' => true],
                ['name' => 'linkText', 'label' => 'Tekst linka', 'type' => 'text', 'tr' => true],
                ['name' => 'to', 'label' => 'Link', 'type' => 'url'],
            ]],
            'rich_text' => ['label' => 'Rich tekst', 'icon' => 'type', 'opis' => 'Formatiran tekst', 'fields' => [
                ['name' => 'sadrzaj', 'label' => 'Sadržaj', 'type' => 'richtext', 'tr' => true],
            ]],
            'card_grid' => ['label' => 'Mreža kartica', 'icon' => 'layout-grid', 'opis' => 'Biznisi, priče, događaji…', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'resource', 'label' => 'Izvor', 'type' => 'select', 'required' => true, 'options' => ['business' => 'Biznisi', 'location' => 'Lokaliteti', 'event' => 'Događaji', 'ad' => 'Oglasi', 'story' => 'Priče', 'news' => 'Vijesti']],
                ['name' => 'kategorija', 'label' => 'Kategorija (ključ, opciono)', 'type' => 'text'],
                ['name' => 'limit', 'label' => 'Broj kartica', 'type' => 'number'],
                ['name' => 'cols', 'label' => 'Kolona', 'type' => 'select', 'options' => ['3' => '3', '4' => '4']],
                ['name' => 'linkText', 'label' => 'Tekst linka', 'type' => 'text', 'tr' => true],
                ['name' => 'cilj', 'label' => 'Link „Vidi sve"', 'type' => 'target'],
                ['name' => 'ukljuciZavrsene', 'label' => 'Prikaži i završene događaje', 'type' => 'toggle'],
                ['name' => 'ukljuciIstekle', 'label' => 'Prikaži i istekle oglase', 'type' => 'toggle'],
            ]],
            'resource_list' => ['label' => 'Lista sadržaja', 'icon' => 'list', 'opis' => 'Puna lista s paginacijom', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'resource', 'label' => 'Izvor', 'type' => 'select', 'options' => ['' => 'Kao na stranici', 'business' => 'Biznisi', 'location' => 'Lokaliteti', 'event' => 'Događaji', 'ad' => 'Oglasi', 'story' => 'Priče', 'news' => 'Vijesti', 'procurement' => 'Javne nabavke']],
                ['name' => 'kategorija', 'label' => 'Kategorija (slug, opciono)', 'type' => 'text'],
                ['name' => 'perPage', 'label' => 'Po strani', 'type' => 'number'],
                ['name' => 'cols', 'label' => 'Kolona', 'type' => 'select', 'options' => ['3' => '3', '4' => '4']],
                ['name' => 'filteri', 'label' => 'Prikaži filter kategorija', 'type' => 'toggle'],
                ['name' => 'pretraga', 'label' => 'Prikaži pretragu', 'type' => 'toggle'],
                ['name' => 'ukljuciZavrsene', 'label' => 'Prikaži i završene događaje', 'type' => 'toggle'],
                ['name' => 'ukljuciIstekle', 'label' => 'Prikaži i istekle oglase', 'type' => 'toggle'],
                ['name' => 'kalendar', 'label' => 'Omogući prikaz kalendara (događaji)', 'type' => 'toggle'],
            ]],
            'cta' => ['label' => 'Poziv na akciju', 'icon' => 'megaphone', 'opis' => 'CTA sa dugmadima', 'fields' => [
                ['name' => 'title', 'label' => 'Naslov', 'type' => 'text', 'tr' => true, 'required' => true],
                ['name' => 'text', 'label' => 'Tekst', 'type' => 'textarea', 'tr' => true],
                ['name' => 'buttons', 'label' => 'Dugmad', 'type' => 'repeater', 'fields' => [
                    ['name' => 'label', 'label' => 'Tekst', 'type' => 'text', 'tr' => true, 'required' => true],
                    ['name' => 'cilj', 'label' => 'Link', 'type' => 'target'],
                    ['name' => 'variant', 'label' => 'Stil', 'type' => 'select', 'options' => ['sekundarna' => 'Sekundarna', 'primary' => 'Primarna']],
                ]],
            ]],
            'category_nav' => ['label' => 'Navigacija kategorija', 'icon' => 'grid-2x2', 'opis' => 'Prečice po kategorijama', 'fields' => [
                ['name' => 'items', 'label' => 'Stavke', 'type' => 'repeater', 'fields' => [
                    ['name' => 'label', 'label' => 'Naziv', 'type' => 'text', 'tr' => true, 'required' => true],
                    ['name' => 'icon', 'label' => 'Ikona', 'type' => 'icon'],
                    ['name' => 'boja', 'label' => 'Boja', 'type' => 'color'],
                    ['name' => 'cilj', 'label' => 'Link', 'type' => 'target'],
                ]],
            ]],
            'gallery' => ['label' => 'Galerija', 'icon' => 'images', 'opis' => 'Foto galerija', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'variant', 'label' => 'Prikaz', 'type' => 'select', 'options' => ['grid' => 'Mreža', 'carousel' => 'Karusel']],
                ['name' => 'items', 'label' => 'Slike', 'type' => 'repeater', 'fields' => [
                    ['name' => 'src', 'label' => 'Slika', 'type' => 'image', 'required' => true],
                    ['name' => 'alt', 'label' => 'Opis', 'type' => 'text', 'tr' => true],
                ]],
            ]],
            'video' => ['label' => 'Video', 'icon' => 'play', 'opis' => 'Ugrađeni video', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'src', 'label' => 'URL videa', 'type' => 'url', 'required' => true],
                ['name' => 'poster', 'label' => 'URL postera', 'type' => 'url'],
            ]],
            'map' => ['label' => 'Mapa', 'icon' => 'map', 'opis' => 'Interaktivna mapa', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov', 'type' => 'text', 'tr' => true],
                ['name' => 'linkText', 'label' => 'Tekst linka', 'type' => 'text', 'tr' => true],
                ['name' => 'cilj', 'label' => 'Link', 'type' => 'target'],
                ['name' => 'height', 'label' => 'Visina', 'type' => 'text'],
            ]],
            'map_explorer' => ['label' => 'Mapa - puna (filteri + ponuda)', 'icon' => 'map', 'opis' => 'Napredna mapa: filteri, naselja, lista ponude', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov liste', 'type' => 'text', 'tr' => true],
            ]],
            'contact_form' => ['label' => 'Kontakt forma', 'icon' => 'mail', 'opis' => 'Forma za poruke + kontakt info', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov', 'type' => 'text', 'tr' => true],
                ['name' => 'prikaziMapu', 'label' => 'Prikaži mini mapu', 'type' => 'toggle'],
            ]],
            'related_content' => ['label' => 'Povezani sadržaj', 'icon' => 'sparkles', 'opis' => 'Najnovije: biznis, lokalitet, događaj', 'fields' => [
                ['name' => 'kicker', 'label' => 'Nadnaslov', 'type' => 'text', 'tr' => true],
                ['name' => 'naslov', 'label' => 'Naslov', 'type' => 'text', 'tr' => true],
            ]],
            'stepper' => ['label' => 'Koraci', 'icon' => 'list-ordered', 'opis' => 'Korak po korak', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'podnaslov', 'label' => 'Podnaslov', 'type' => 'textarea', 'tr' => true],
                ['name' => 'steps', 'label' => 'Koraci', 'type' => 'repeater', 'fields' => [
                    ['name' => 'icon', 'label' => 'Ikona', 'type' => 'text'],
                    ['name' => 'title', 'label' => 'Naslov koraka', 'type' => 'text', 'tr' => true, 'required' => true],
                    ['name' => 'text', 'label' => 'Opis', 'type' => 'textarea', 'tr' => true],
                ]],
            ]],
            'paths' => ['label' => 'Putanje', 'icon' => 'signpost', 'opis' => 'Kartice izbora (2 kolone)', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'podnaslov', 'label' => 'Podnaslov', 'type' => 'textarea', 'tr' => true],
                ['name' => 'paths', 'label' => 'Kartice', 'type' => 'repeater', 'fields' => [
                    ['name' => 'icon', 'label' => 'Ikona', 'type' => 'text'],
                    ['name' => 'title', 'label' => 'Naslov', 'type' => 'text', 'tr' => true, 'required' => true],
                    ['name' => 'text', 'label' => 'Opis', 'type' => 'textarea', 'tr' => true],
                    ['name' => 'features', 'label' => 'Stavke', 'type' => 'repeater', 'fields' => [
                        ['name' => 'text', 'label' => 'Tekst', 'type' => 'text', 'tr' => true, 'required' => true],
                    ]],
                    ['name' => 'buttonLabel', 'label' => 'Tekst dugmeta', 'type' => 'text', 'tr' => true],
                    ['name' => 'buttonUrl', 'label' => 'Link dugmeta', 'type' => 'url'],
                ]],
            ]],
            'features' => ['label' => 'Prednosti', 'icon' => 'grid-2x2-check', 'opis' => 'Mreža ikona (3 kolone)', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'podnaslov', 'label' => 'Podnaslov', 'type' => 'textarea', 'tr' => true],
                ['name' => 'items', 'label' => 'Stavke', 'type' => 'repeater', 'fields' => [
                    ['name' => 'icon', 'label' => 'Ikona', 'type' => 'text'],
                    ['name' => 'title', 'label' => 'Naslov', 'type' => 'text', 'tr' => true, 'required' => true],
                    ['name' => 'text', 'label' => 'Opis', 'type' => 'textarea', 'tr' => true],
                ]],
            ]],
            'info_panel' => ['label' => 'Info panel', 'icon' => 'panels-top-left', 'opis' => 'Istaknute stavke', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov', 'type' => 'text', 'tr' => true],
                ['name' => 'items', 'label' => 'Stavke', 'type' => 'repeater', 'fields' => [
                    ['name' => 'icon', 'label' => 'Ikona', 'type' => 'text'],
                    ['name' => 'label', 'label' => 'Oznaka', 'type' => 'text', 'tr' => true, 'required' => true],
                    ['name' => 'value', 'label' => 'Vrijednost', 'type' => 'text', 'tr' => true, 'required' => true],
                    ['name' => 'href', 'label' => 'Link (opciono)', 'type' => 'url'],
                ]],
            ]],
            'faq' => ['label' => 'FAQ', 'icon' => 'messages-square', 'opis' => 'Pitanja i odgovori', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'items', 'label' => 'Pitanja', 'type' => 'repeater', 'fields' => [
                    ['name' => 'q', 'label' => 'Pitanje', 'type' => 'text', 'tr' => true, 'required' => true],
                    ['name' => 'a', 'label' => 'Odgovor', 'type' => 'textarea', 'tr' => true, 'required' => true],
                ]],
            ]],
            'stats' => ['label' => 'Statistika', 'icon' => 'chart-column', 'opis' => 'Brojači', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'items', 'label' => 'Brojači', 'type' => 'repeater', 'fields' => [
                    ['name' => 'value', 'label' => 'Vrijednost', 'type' => 'text', 'required' => true],
                    ['name' => 'label', 'label' => 'Oznaka', 'type' => 'text', 'tr' => true, 'required' => true],
                ]],
            ]],
            'partners' => ['label' => 'Partneri', 'icon' => 'handshake', 'opis' => 'Traka logotipa', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'items', 'label' => 'Partneri', 'type' => 'repeater', 'fields' => [
                    ['name' => 'name', 'label' => 'Naziv', 'type' => 'text', 'tr' => true, 'required' => true],
                    ['name' => 'logo', 'label' => 'Logo', 'type' => 'image'],
                    ['name' => 'url', 'label' => 'Link (opciono)', 'type' => 'url'],
                ]],
            ]],
            'featured_story' => ['label' => 'Izdvojena priča', 'icon' => 'star', 'opis' => 'Izdvojeni sadržaj', 'fields' => [
                ['name' => 'naslov', 'label' => 'Naslov sekcije', 'type' => 'text', 'tr' => true],
                ['name' => 'slug', 'label' => 'Slug priče (prazno = zadnja)', 'type' => 'text'],
            ]],
            'author' => ['label' => 'Autor', 'icon' => 'user', 'opis' => 'Blok autora', 'fields' => [
                ['name' => 'ime', 'label' => 'Ime', 'type' => 'text', 'tr' => true, 'required' => true],
                ['name' => 'uloga', 'label' => 'Uloga', 'type' => 'text', 'tr' => true],
                ['name' => 'bio', 'label' => 'Biografija', 'type' => 'textarea', 'tr' => true],
                ['name' => 'avatar', 'label' => 'Avatar', 'type' => 'image'],
            ]],
            'spacer' => ['label' => 'Razmak', 'icon' => 'move-vertical', 'opis' => 'Vertikalni razmak', 'fields' => [
                ['name' => 'size', 'label' => 'Veličina', 'type' => 'select', 'options' => ['sm' => 'Mala', 'md' => 'Srednja', 'lg' => 'Velika']],
                ['name' => 'divider', 'label' => 'Linija razdvajanja', 'type' => 'toggle'],
            ]],
        ];
    }

    public static function defaults(string $type): ?array
    {
        $def = self::all()[$type] ?? null;

        if (! $def) {
            return null;
        }

        $data = [];

        foreach ($def['fields'] as $field) {
            $data[$field['name']] = self::fieldDefault($field);
        }

        $data['settings'] = ['background' => null, 'padding' => null, 'width' => null, 'hidden' => false];

        return ['type' => $type, 'data' => $data];
    }

    protected static function fieldDefault(array $field): mixed
    {
        return match ($field['type'] ?? 'text') {
            'repeater' => [],
            'toggle' => false,
            'select' => array_key_first($field['options'] ?? []) ?? null,
            'image' => null,
            'number' => null,
            default => ! empty($field['tr']) ? null : '',
        };
    }

    public static function catalog(): array
    {
        return collect(self::all())->map(fn ($def, $type) => [
            'type' => $type,
            'label' => $def['label'],
            'icon' => $def['icon'],
            'opis' => $def['opis'],
        ])->values()->all();
    }

    /** Wrap prevodivih polja bloka u mapu {sr: value} (za migraciju). */
    public static function wrapBlock(array $block): array
    {
        $type = $block['type'] ?? null;
        $def = self::all()[$type] ?? null;

        if (! $def) {
            return $block;
        }

        $data = $block['data'] ?? [];

        foreach ($def['fields'] as $field) {
            $name = $field['name'];

            if (($field['type'] ?? null) === 'repeater') {
                if (is_array($data[$name] ?? null)) {
                    $data[$name] = array_map(function ($item) use ($field) {
                        foreach ($field['fields'] as $sub) {
                            if (! empty($sub['tr']) && array_key_exists($sub['name'], $item) && ! self::isMap($item[$sub['name']])) {
                                $item[$sub['name']] = ['sr' => (string) $item[$sub['name']]];
                            }
                        }

                        return $item;
                    }, $data[$name]);
                }

                continue;
            }

            if (! empty($field['tr']) && array_key_exists($name, $data) && $data[$name] !== null && ! self::isMap($data[$name])) {
                $data[$name] = ['sr' => (string) $data[$name]];
            }
        }

        $block['data'] = $data;

        return $block;
    }

    protected static function isMap(mixed $v): bool
    {
        return is_array($v) && ! array_is_list($v);
    }
}
