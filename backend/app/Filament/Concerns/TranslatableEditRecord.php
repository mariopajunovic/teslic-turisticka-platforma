<?php

namespace App\Filament\Concerns;

trait TranslatableEditRecord
{
    use ResolvesTranslationLocale;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $locale = $this->activeTranslationLocale();
        $record = $this->getRecord();

        foreach ($this->translatableAttributes() as $attr) {
            if (array_key_exists($attr, $data)) {
                $data[$attr] = $record->getTranslations($attr)[$locale] ?? null;
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $locale = $this->activeTranslationLocale();
        $record = $this->getRecord();

        foreach ($this->translatableAttributes() as $attr) {
            if (array_key_exists($attr, $data)) {
                $translations = $record->getTranslations($attr);
                $translations[$locale] = $data[$attr];
                $data[$attr] = $translations;
            }
        }

        return $data;
    }
}
