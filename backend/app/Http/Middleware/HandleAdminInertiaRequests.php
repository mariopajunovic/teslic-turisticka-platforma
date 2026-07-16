<?php

namespace App\Http\Middleware;

use App\Enums\ContentStatus;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\News;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Middleware;

class HandleAdminInertiaRequests extends Middleware
{
    protected $rootView = 'administracija';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $admin = $request->user('admin');

        return [
            ...parent::share($request),
            'auth' => [
                'admin' => $admin ? [
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'initials' => $this->initials($admin->name),
                    'roles' => $admin->getRoleNames()->values()->all(),
                    'is_super' => (bool) $admin->is_super,
                ] : null,
            ],
            'flash' => [
                'status' => fn () => $request->session()->get('status'),
                'error' => fn () => $request->session()->get('error'),
                'recoveryCodes' => fn () => $request->session()->get('recoveryCodes'),
            ],
            'badges' => [
                'odobravanje' => fn () => $this->odobravanjeCount(),
            ],
        ];
    }

    protected function odobravanjeCount(): int
    {
        $poslano = ContentStatus::Poslano->value;

        return Business::where('status', $poslano)->count()
            + Location::where('status', $poslano)->count()
            + Event::where('status', $poslano)->count()
            + Ad::where('status', $poslano)->count()
            + Story::where('status', $poslano)->count()
            + News::where('status', $poslano)->count();
    }

    protected function initials(?string $name): string
    {
        $name = trim((string) $name);

        if ($name === '') {
            return '?';
        }

        $parts = preg_split('/\s+/', $name);
        $first = Str::substr($parts[0], 0, 1);
        $last = count($parts) > 1 ? Str::substr($parts[count($parts) - 1], 0, 1) : '';

        return Str::upper($first.$last);
    }
}
