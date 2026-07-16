<?php

namespace App\Filament\Concerns;

trait ResolvesTranslationLocale
{
    protected function activeTranslationLocale(): string
    {
        $locales = (array) config('locales.content');
        $locale = session('filament_locale', $locales[0]);

        return in_array($locale, $locales, true) ? $locale : $locales[0];
    }

    protected function translatableAttributes(): array
    {
        $model = static::getResource()::getModel();

        return (new $model)->getTranslatableAttributes();
    }
}
