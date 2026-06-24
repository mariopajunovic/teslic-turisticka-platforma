<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\Page;
use App\Models\Story;
use Illuminate\Http\Response;

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
            $urls[] = ['loc' => url($path), 'lastmod' => now()->toIso8601String()];
        }

        Business::objavljeno()->select(['slug', 'updated_at'])->each(function ($item) use (&$urls) {
            $urls[] = ['loc' => url('/domace-je-najbolje/'.$item->slug), 'lastmod' => $item->updated_at->toIso8601String()];
        });

        Location::objavljeno()->select(['slug', 'updated_at'])->each(function ($item) use (&$urls) {
            $urls[] = ['loc' => url('/turizam/'.$item->slug), 'lastmod' => $item->updated_at->toIso8601String()];
        });

        Event::objavljeno()->select(['slug', 'updated_at'])->each(function ($item) use (&$urls) {
            $urls[] = ['loc' => url('/dogadjaji/'.$item->slug), 'lastmod' => $item->updated_at->toIso8601String()];
        });

        Story::objavljeno()->select(['slug', 'updated_at'])->each(function ($item) use (&$urls) {
            $urls[] = ['loc' => url('/price/'.$item->slug), 'lastmod' => $item->updated_at->toIso8601String()];
        });

        Page::published()->select(['slug', 'updated_at'])->each(function ($item) use (&$urls) {
            $loc = $item->slug === 'pocetna' ? url('/') : url('/'.$item->slug);
            $urls[] = ['loc' => $loc, 'lastmod' => $item->updated_at->toIso8601String()];
        });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $entry) {
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.htmlspecialchars($entry['loc']).'</loc>'."\n";
            $xml .= '    <lastmod>'.$entry['lastmod'].'</lastmod>'."\n";
            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
