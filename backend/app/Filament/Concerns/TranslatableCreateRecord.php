<?php

namespace App\Filament\Concerns;

trait TranslatableCreateRecord
{
    use ResolvesTranslationLocale;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $locale = $this->activeTranslationLocale();

        foreach ($this->translatableAttributes() as $attr) {
            if (array_key_exists($attr, $data)) {
                $data[$attr] = [$locale => $data[$attr]];
            }
        }

        return $data;
    }
}
