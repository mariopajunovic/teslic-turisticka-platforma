<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Settings\SiteSettings;
use App\Settings\StraniceSettings;
use App\Support\ActiveLocale;
use App\Support\Cyrillic;

class SiteData
{
    protected static function tr(mixed $value): mixed
    {
        if (! app(ActiveLocale::class)->isCyrillic()) {
            return $value;
        }

        return is_array($value) ? Cyrillic::deep($value) : Cyrillic::convert($value);
    }

    public static function shared(): array
    {
        $visible = fn ($q) => $q->where('visible', true);

        $menus = Menu::with([
            'rootItems' => $visible,
            'rootItems.children' => $visible,
        ])->get()->keyBy('key');

        $settings = app(SiteSettings::class);

        $straniceSettings = app(StraniceSettings::class);

        return [
            'mainNav' => self::tree($menus->get('main')),
            'secondaryNav' => self::flat($menus->get('secondary')),
            'footerLinks' => [
                'brzi' => self::flat($menus->get('footer_brzi')),
                'istrazi' => self::flat($menus->get('footer_istrazi')),
                'pravno' => self::flat($menus->get('footer_pravno')),
            ],
            'kontakt' => [
                'adresa' => self::tr($settings->kontakt_adresa),
                'telefon' => $settings->kontakt_telefon,
                'email' => $settings->kontakt_email,
            ],
            'postavke' => [
                'brandNaziv' => self::tr($settings->brand_naziv),
                'brandLogoTekst' => self::tr($settings->brand_logo_tekst),
                'footerOpis' => self::tr($settings->footer_opis),
                'copyright' => self::tr($settings->copyright),
                'social' => $settings->social,
                'partneri' => $settings->partneri,
                'indeksiranje' => $settings->google_indeksiranje,
            ],
            'texts' => self::tr($straniceSettings->toArray()),
            'kategorije' => Category::orderBy('sort')->get()->map(fn ($c) => ['key' => $c->key, 'label' => $c->label, 'icon' => $c->icon, 'color' => $c->color])->all(),
        ];
    }

    protected static function tree(?Menu $menu): array
    {
        if (! $menu) {
            return [];
        }

        return $menu->rootItems->map(function (MenuItem $item) {
            $node = ['label' => $item->label, 'to' => $item->url];

            if ($item->children->isNotEmpty()) {
                $node['children'] = $item->children
                    ->map(fn (MenuItem $c) => ['label' => $c->label, 'to' => $c->url])
                    ->all();
            }

            return $node;
        })->all();
    }

    protected static function flat(?Menu $menu): array
    {
        if (! $menu) {
            return [];
        }

        return $menu->rootItems
            ->map(fn (MenuItem $item) => ['label' => $item->label, 'to' => $item->url])
            ->all();
    }
}
