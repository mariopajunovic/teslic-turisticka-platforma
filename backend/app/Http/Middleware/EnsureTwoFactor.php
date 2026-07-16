<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactor
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin = auth('admin')->user();

        if ($admin && ! $admin->getAppAuthenticationSecret()) {
            $izuzeto = $request->routeIs(
                'administracija.2fa.postavi.show',
                'administracija.2fa.postavi',
                'administracija.odjava',
            );

            if (! $izuzeto) {
                return redirect()->route('administracija.2fa.postavi.show');
            }
        }

        return $next($request);
    }
}
