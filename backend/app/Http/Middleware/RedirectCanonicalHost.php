<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectCanonicalHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $korijen = rtrim((string) config('app.url'), '/');
        $kanonski = parse_url($korijen, PHP_URL_HOST);

        if (! $kanonski || ! $request->isMethod('GET') || $request->getHost() === $kanonski) {
            return $next($request);
        }

        return redirect()->away($korijen.$request->getRequestUri(), 301);
    }
}
