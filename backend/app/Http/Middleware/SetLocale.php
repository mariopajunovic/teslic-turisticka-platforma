<?php

namespace App\Http\Middleware;

use App\Support\ActiveLocale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $active = app(ActiveLocale::class);

        $segment = $request->segment(1);
        $prefixed = (array) config('locales.prefixed');
        $language = in_array($segment, $prefixed, true) ? $segment : (string) config('locales.default');

        $script = 'lat';
        if ($language === 'sr') {
            $script = $request->cookie('pismo') === 'cir' ? 'cir' : 'lat';
        }

        $active->set($language, $script);
        app()->setLocale($active->appLocale());

        return $next($request);
    }
}
