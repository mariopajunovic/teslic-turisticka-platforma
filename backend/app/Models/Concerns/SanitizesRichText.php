<?php

namespace App\Models\Concerns;

use App\Support\SafeHtml;

trait SanitizesRichText
{
    public static function bootSanitizesRichText(): void
    {
        static::saving(function ($model) {
            foreach ($model->richTextFields() as $polje) {
                if (! array_key_exists($polje, $model->getAttributes())) {
                    continue;
                }

                if (method_exists($model, 'getTranslations') && in_array($polje, $model->getTranslatableAttributes(), true)) {
                    $model->setTranslations(
                        $polje,
                        array_map(fn ($v) => is_string($v) ? SafeHtml::clean($v) : $v, $model->getTranslations($polje)),
                    );

                    continue;
                }

                $vrijednost = $model->getAttribute($polje);

                if (is_string($vrijednost)) {
                    $model->setAttribute($polje, SafeHtml::clean($vrijednost));
                }
            }
        });
    }

    public function richTextFields(): array
    {
        return $this->richText ?? [];
    }
}
