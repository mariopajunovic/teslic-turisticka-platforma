<?php

namespace App\Http\Middleware;

use App\Settings\SiteSettings;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiteAvailable
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = app(SiteSettings::class);

        if (! $settings->odrzavanje) {
            return $next($request);
        }

        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        if ($request->is('admin', 'admin/*', 'administracija', 'administracija/*', 'build/*', 'storage/*', 'up', 'robots.txt', 'sitemap.xml')) {
            return $next($request);
        }

        $brandTekst = is_array($settings->brand_logo_tekst)
            ? ($settings->brand_logo_tekst['sr'] ?? 'Teslić')
            : $settings->brand_logo_tekst;

        return response()->view('maintenance', [
            'poruka' => $settings->odrzavanje_poruka,
            'brand' => $brandTekst,
            'logo' => $settings->brand_logo
                ? \Illuminate\Support\Facades\Storage::disk('public')->url($settings->brand_logo)
                : asset('logo.svg'),
            'email' => $settings->kontakt_email,
        ], 503);
    }
}
