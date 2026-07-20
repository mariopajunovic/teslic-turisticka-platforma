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

    protected static function trs(mixed $value): mixed
    {
        if (is_array($value)) {
            $lang = app(ActiveLocale::class)->language();
            $resolved = $value[$lang] ?? '';

            if ($resolved === '' && $lang !== 'sr') {
                $resolved = $value['sr'] ?? '';
            }

            $value = $resolved;
        }

        return self::tr($value);
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
                'brandNaziv' => self::trs($settings->brand_naziv),
                'brandLogoTekst' => self::trs($settings->brand_logo_tekst),
                'brandLogo' => $settings->brand_logo ? \Illuminate\Support\Facades\Storage::disk('public')->url($settings->brand_logo) : null,
                'logoVisina' => $settings->logo_visina,
                'seoOpis' => self::trs($settings->seo_opis),
                'footerOpis' => self::trs($settings->footer_opis),
                'copyright' => self::trs($settings->copyright),
                'social' => $settings->social,
                'partneriTekst' => self::trs($settings->partneri_tekst),
                'partneri' => \App\Models\Partner::orderBy('sort_order')->orderBy('id')->get()->map(fn ($p) => [
                    'naziv' => $p->naziv,
                    'href' => $p->href,
                    'logo' => $p->logoUrl(),
                ])->all(),
                'indeksiranje' => $settings->google_indeksiranje,
                'captchaSiteKey' => $settings->captcha_site_key,
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
            $to = $item->razrijeseniUrl();

            if ($to === null) {
                return null;
            }

            $node = ['label' => $item->label, 'to' => $to];

            $djeca = $item->children
                ->map(fn (MenuItem $c) => ($url = $c->razrijeseniUrl()) ? ['label' => $c->label, 'to' => $url] : null)
                ->filter()
                ->values();

            if ($djeca->isNotEmpty()) {
                $node['children'] = $djeca->all();
            }

            return $node;
        })->filter()->values()->all();
    }

    protected static function flat(?Menu $menu): array
    {
        if (! $menu) {
            return [];
        }

        return $menu->rootItems
            ->map(fn (MenuItem $item) => ($url = $item->razrijeseniUrl()) ? ['label' => $item->label, 'to' => $url] : null)
            ->filter()
            ->values()
            ->all();
    }
}
