<?php

namespace App\Support;

use App\Models\Page;

class Breadcrumbs
{
    public static function detail(string $tip, string $naslov, ?string $url): array
    {
        $stavke = [self::pocetna()];
        $kolekcija = ResourceUrls::collectionPage($tip);

        if ($kolekcija) {
            $stavke[] = [
                'name' => (string) $kolekcija->title,
                'url' => ResourceUrls::collection($tip),
            ];
        }

        if ($url) {
            $stavke[] = ['name' => $naslov, 'url' => $url];
        }

        return $stavke;
    }

    public static function stranica(Page $page): array
    {
        $active = app(ActiveLocale::class);

        if ($page->isHome()) {
            return [self::pocetna()];
        }

        return [
            self::pocetna(),
            ['name' => (string) $page->title, 'url' => $active->path($page->pathFor())],
        ];
    }

    protected static function pocetna(): array
    {
        return [
            'name' => app(Translations::class)->get('common.home'),
            'url' => app(ActiveLocale::class)->path('/'),
        ];
    }
}
