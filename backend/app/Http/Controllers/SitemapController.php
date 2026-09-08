<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\Page;
use App\Models\Story;
use App\Settings\SiteSettings;
use Illuminate\Http\Response;
use App\Support\ActiveLocale;
use App\Support\ResourceUrls;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        $statics = [
            '/',
            '/domace-je-najbolje',
            '/turizam',
            '/dogadjaji',
            '/oglasi',
            '/price',
            '/mapa',
            '/o-projektu',
            '/kontakt',
            '/pridruzi-se',
        ];

        foreach ($statics as $path) {
            $urls[] = ['loc' => url($path), 'lastmod' => now()->toIso8601String(), 'alternates' => []];
        }

        foreach ([Business::class, Location::class, Event::class, Story::class] as $model) {
            $model::objavljeno()->select(['slug', 'naslov', 'updated_at'])->each(function ($item) use (&$urls) {
                $this->dodajVerzije($urls, $item, 'naslov', fn ($lang) => ResourceUrls::detail($item, $lang));
            });
        }

        Page::published()->with('parent')->select(['id', 'parent_id', 'slug', 'title', 'updated_at'])->each(function ($item) use (&$urls) {
            $this->dodajVerzije($urls, $item, 'title', fn ($lang) => app(ActiveLocale::class)->path($item->pathFor($lang), $lang));
        });

        $urls = array_values(array_column($urls, null, 'loc'));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        foreach ($urls as $entry) {
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.htmlspecialchars($entry['loc']).'</loc>'."\n";
            $xml .= '    <lastmod>'.$entry['lastmod'].'</lastmod>'."\n";

            foreach ($entry['alternates'] as $lang => $href) {
                $xml .= '    <xhtml:link rel="alternate" hreflang="'.$lang.'" href="'.htmlspecialchars($href).'" />'."\n";
            }

            if ($entry['alternates']['sr'] ?? null) {
                $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="'.htmlspecialchars($entry['alternates']['sr']).'" />'."\n";
            }

            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    protected function dodajVerzije(array &$urls, object $item, string $polje, callable $putanja): void
    {
        $prevodi = $item->getTranslations($polje);
        $verzije = [];

        foreach (array_merge(['sr'], (array) config('locales.prefixed')) as $lang) {
            if ($lang !== 'sr' && ! filled($prevodi[$lang] ?? null)) {
                continue;
            }

            $putanjaJezika = $putanja($lang);

            if ($putanjaJezika) {
                $verzije[$lang] = url($putanjaJezika);
            }
        }

        $alternates = count($verzije) > 1 ? $verzije : [];
        $lastmod = $item->updated_at->toIso8601String();

        foreach ($verzije as $loc) {
            $urls[] = ['loc' => $loc, 'lastmod' => $lastmod, 'alternates' => $alternates];
        }
    }

    public function robots(): Response
    {
        if (! app(SiteSettings::class)->google_indeksiranje) {
            return response("User-agent: *\nDisallow: /\n", 200)->header('Content-Type', 'text/plain');
        }

        $content = "User-agent: facebookexternalhit\nAllow: /\n\n"
            ."User-agent: Twitterbot\nAllow: /\n\n"
            ."User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
