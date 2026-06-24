<?php

namespace App\Support;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Settings\SiteSettings;

class SiteData
{
    public static function shared(): array
    {
        $visible = fn ($q) => $q->where('visible', true);

        $menus = Menu::with([
            'rootItems' => $visible,
            'rootItems.children' => $visible,
        ])->get()->keyBy('key');

        $settings = app(SiteSettings::class);

        return [
            'mainNav' => self::tree($menus->get('main')),
            'secondaryNav' => self::flat($menus->get('secondary')),
            'footerLinks' => [
                'brzi' => self::flat($menus->get('footer_brzi')),
                'istrazi' => self::flat($menus->get('footer_istrazi')),
                'pravno' => self::flat($menus->get('footer_pravno')),
            ],
            'kontakt' => [
                'adresa' => $settings->kontakt_adresa,
                'telefon' => $settings->kontakt_telefon,
                'email' => $settings->kontakt_email,
            ],
            'postavke' => [
                'brandNaziv' => $settings->brand_naziv,
                'brandLogoTekst' => $settings->brand_logo_tekst,
                'footerOpis' => $settings->footer_opis,
                'copyright' => $settings->copyright,
                'social' => $settings->social,
                'partneri' => $settings->partneri,
            ],
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
