<?php

use App\Http\Middleware\EnsureRole;
use App\Http\Middleware\HandleAdminInertiaRequests;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {
            Route::middleware('admin')
                ->prefix('administracija')
                ->name('administracija.')
                ->group(base_path('routes/administracija.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            HandleInertiaRequests::class,
            \App\Http\Middleware\EnsureSiteAvailable::class,
        ]);

        $middleware->group('admin', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            HandleAdminInertiaRequests::class,
        ]);

        $middleware->alias([
            'role' => EnsureRole::class,
            'admin.access' => \App\Http\Middleware\EnsureAdminAccess::class,
        ]);

        $middleware->redirectGuestsTo(fn (Request $request) => $request->is('administracija', 'administracija/*')
            ? '/administracija/prijava'
            : '/prijava');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
