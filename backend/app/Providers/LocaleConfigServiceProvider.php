<?php

namespace App\Providers;

use App\Models\Locale;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class LocaleConfigServiceProvider extends ServiceProvider
{
    public const CACHE_KEY = 'locales.active';

    public function boot(): void
    {
        $locales = $this->activeLocales();

        if (empty($locales)) {
            return;
        }

        $default = 'sr';
        $codes = array_column($locales, 'code');

        config([
            'locales.content' => $codes,
            'locales.default' => $default,
            'locales.prefixed' => array_values(array_filter($codes, fn ($c) => $c !== $default)),
            'locales.languages' => collect($locales)->mapWithKeys(fn ($l) => [
                $l['code'] => [
                    'label' => $l['name'],
                    'short' => mb_strtoupper($l['code']),
                    'prefix' => $l['code'] === $default ? '' : $l['code'],
                    'html' => $l['code'],
                ],
            ])->all(),
            'locales.app_locale' => collect($locales)->mapWithKeys(fn ($l) => [
                $l['code'] => $l['code'] === 'sr'
                    ? ['lat' => 'sr_Latn', 'cir' => 'sr_Cyrl']
                    : ['lat' => $l['code'], 'cir' => $l['code']],
            ])->all(),
        ]);
    }

    protected function activeLocales(): array
    {
        try {
            if (! Schema::hasTable('locales')) {
                return [];
            }

            return Cache::rememberForever(self::CACHE_KEY, fn () => Locale::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(['code', 'name'])
                ->map(fn (Locale $l) => ['code' => $l->code, 'name' => $l->name])
                ->all());
        } catch (\Throwable $e) {
            return [];
        }
    }
}
