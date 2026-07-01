<?php

namespace App\Http\Middleware;

use App\Settings\SiteSettings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiteAvailable
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = app(SiteSettings::class);

        if (! $settings->odrzavanje) {
            return $next($request);
        }

        if ($request->is('admin', 'admin/*', 'odrzavanje/*', 'build/*', 'storage/*', 'up', 'robots.txt', 'sitemap.xml')) {
            return $next($request);
        }

        $until = (int) $request->cookie('site_unlock', 0);
        if ($until > now()->timestamp) {
            return $next($request);
        }

        return response()->view('maintenance', [
            'poruka' => $settings->odrzavanje_poruka,
            'brand' => $settings->brand_logo_tekst,
            'minuta' => (int) $settings->odrzavanje_minuta,
            'greska' => session('maintenance_error'),
        ], 503);
    }
}
