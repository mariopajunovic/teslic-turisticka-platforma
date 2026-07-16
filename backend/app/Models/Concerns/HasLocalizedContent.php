<?php

namespace App\Models\Concerns;

use App\Support\ActiveLocale;
use App\Support\Cyrillic;
use Spatie\Translatable\HasTranslations;

trait HasLocalizedContent
{
    use HasTranslations {
        getTranslation as protected baseGetTranslation;
    }

    public function getTranslation(string $key, string $locale, bool $useFallbackLocale = true): mixed
    {
        $active = app(ActiveLocale::class);
        $contentLocale = $this->resolveContentLocale($locale, $active);

        $value = $this->baseGetTranslation($key, $contentLocale, false);

        if ($useFallbackLocale && $contentLocale !== 'sr' && $this->isEmptyTranslation($value)) {
            $value = $this->baseGetTranslation($key, 'sr', false);
        }

        if ($active->isCyrillic() && $contentLocale === 'sr') {
            return is_array($value) ? Cyrillic::deep($value) : Cyrillic::convert($value);
        }

        return $value;
    }

    protected function isEmptyTranslation(mixed $value): bool
    {
        return $value === null || $value === '' || $value === [];
    }

    protected function resolveContentLocale(string $locale, ActiveLocale $active): string
    {
        $content = (array) config('locales.content');

        if (in_array($locale, $content, true)) {
            return $locale;
        }

        if (in_array($locale, ['sr_Latn', 'sr_Cyrl', 'sr-Latn', 'sr-Cyrl'], true)) {
            return 'sr';
        }

        return $active->language();
    }
}
