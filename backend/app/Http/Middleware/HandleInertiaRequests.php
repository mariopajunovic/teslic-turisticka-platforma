<?php

namespace App\Http\Middleware;

use App\Support\ActiveLocale;
use App\Support\SiteData;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $locale = app(ActiveLocale::class);

        $path = '/'.ltrim($request->path(), '/');
        $prefix = $locale->prefix();
        $basePath = ($prefix !== '' && str_starts_with($path, '/'.$prefix))
            ? (substr($path, strlen('/'.$prefix)) ?: '/')
            : $path;

        $query = $request->getQueryString();
        $suffix = $query ? '?'.$query : '';

        $alternates = [];
        foreach (array_keys((array) config('locales.languages')) as $lang) {
            $alternates[$lang] = url($locale->path($basePath, $lang)).$suffix;
        }

        return [
            ...parent::share($request),
            'site' => SiteData::shared(),
            'locale' => [
                'language' => $locale->language(),
                'script' => $locale->script(),
                'isCyrillic' => $locale->isCyrillic(),
                'prefix' => $prefix,
                'htmlLang' => $locale->htmlLang(),
                'basePath' => $basePath,
                'languages' => $locale->languageOptions(),
                'alternates' => $alternates,
            ],
            'i18n' => fn () => [
                'language' => $locale->language(),
                'messages' => app(\App\Support\Translations::class)->messages($locale->language()),
            ],
            'auth' => [
                'user' => $user ? [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role?->value,
                ] : null,
            ],
            'flash' => [
                'status' => fn () => $request->session()->get('status'),
            ],
        ];
    }
}
