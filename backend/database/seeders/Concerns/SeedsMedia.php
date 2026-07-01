<?php

namespace Database\Seeders\Concerns;

use Spatie\MediaLibrary\HasMedia;

trait SeedsMedia
{
    protected function attachSlika(HasMedia $model, ?string $url): void
    {
        if (! $url || $model->getFirstMedia('naslovna')) {
            return;
        }

        try {
            $model->addMediaFromUrl($url)->toMediaCollection('naslovna');
        } catch (\Throwable $e) {
            // preskoči ako slika nije dostupna
        }
    }
}
