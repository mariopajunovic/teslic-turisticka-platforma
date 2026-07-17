<?php

namespace App\Support;

use App\Models\Locale;

class BlockContent
{
    /** Razriješi prevodive mape u blokovima za dati jezik (fallback sr). */
    public static function resolve(array $blocks, string $lang): array
    {
        $codes = self::codes();

        return array_map(fn ($b) => self::resolveValue($b, $lang, $codes), $blocks);
    }

    protected static function resolveValue(mixed $value, string $lang, array $codes): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        if (self::isLocaleMap($value, $codes)) {
            if (array_key_exists($lang, $value) && $value[$lang] !== '' && $value[$lang] !== null) {
                return $value[$lang];
            }

            return $value['sr'] ?? (reset($value) ?: '');
        }

        $out = [];
        foreach ($value as $k => $v) {
            $out[$k] = self::resolveValue($v, $lang, $codes);
        }

        return $out;
    }

    protected static function isLocaleMap(array $value, array $codes): bool
    {
        if (empty($value) || array_is_list($value)) {
            return false;
        }

        foreach (array_keys($value) as $k) {
            if (! in_array($k, $codes, true)) {
                return false;
            }
        }

        return true;
    }

    protected static function codes(): array
    {
        try {
            return Locale::pluck('code')->merge(['sr', 'en', 'de'])->unique()->values()->all();
        } catch (\Throwable $e) {
            return ['sr', 'en', 'de'];
        }
    }
}
