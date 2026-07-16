<?php

namespace App\Support;

use App\Models\Locale;
use App\Models\Translation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class Translations
{
    protected function cacheKey(string $lang): string
    {
        return "translations.messages.{$lang}";
    }

    public function messages(string $lang): array
    {
        return Cache::rememberForever($this->cacheKey($lang), fn () => $this->build($lang));
    }

    protected function build(string $lang): array
    {
        $fallback = 'sr';
        $out = [];

        Translation::query()
            ->orderBy('key')
            ->get(['key', 'values'])
            ->each(function (Translation $t) use (&$out, $lang, $fallback) {
                $values = (array) ($t->values ?? []);
                $value = $values[$lang] ?? $values[$fallback] ?? $t->key;
                Arr::set($out, $t->key, $value);
            });

        return $out;
    }

    public function forget(): void
    {
        $codes = Locale::pluck('code')->push('sr')->unique();

        foreach ($codes as $code) {
            Cache::forget($this->cacheKey($code));
        }
    }
}
