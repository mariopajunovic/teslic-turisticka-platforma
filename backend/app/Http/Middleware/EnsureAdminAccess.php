<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    public function handle(Request $request, Closure $next, string $ability): Response
    {
        $admin = $request->user('admin');

        abort_unless($admin, 403);

        if ($admin->is_super) {
            return $next($request);
        }

        $allowed = $ability === 'administratori'
            ? $admin->hasRole('administrator')
            : $admin->hasPermissionTo($ability);

        abort_unless($allowed, 403);

        return $next($request);
    }
}
