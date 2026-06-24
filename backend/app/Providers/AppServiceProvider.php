<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Gate::before(fn ($user, string $ability) => ($user instanceof Admin && $user->is_super) ? true : null);

        Event::listen(Login::class, function (Login $event) {
            activity('auth')->causedBy($event->user)->log('Prijava');
        });

        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                activity('auth')->causedBy($event->user)->log('Odjava');
            }
        });
    }
}
