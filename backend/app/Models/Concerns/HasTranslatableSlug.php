<?php

namespace App\Models\Concerns;

use App\Support\ActiveLocale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasTranslatableSlug
{
    public static function bootHasTranslatableSlug(): void
    {
        static::saving(function ($model): void {
            $slugs = array_filter((array) $model->slug, 'is_string', ARRAY_FILTER_USE_KEY);
            $naslovi = json_decode($model->attributes['naslov'] ?? '{}', true) ?: [];

            $jezici = array_unique(array_merge(array_keys($naslovi), array_keys($slugs)));
            if (! in_array('sr', $jezici, true)) {
                $jezici[] = 'sr';
            }

            foreach ($jezici as $lang) {
                $osnova = $slugs[$lang] ?? '';

                if ($osnova === '' && ! empty($naslovi[$lang])) {
                    $osnova = Str::slug($naslovi[$lang]);
                }

                if ($osnova !== '') {
                    $slugs[$lang] = $model->jedinstvenSlug(Str::slug($osnova), $lang);
                }
            }

            $model->slug = $slugs;
        });
    }

    protected function jedinstvenSlug(string $osnova, string $lang): string
    {
        $slug = $osnova;
        $i = 1;

        while (static::query()
            ->where("slug->{$lang}", $slug)
            ->when($this->id, fn ($q) => $q->where('id', '!=', $this->id))
            ->exists()) {
            $i++;
            $slug = $osnova.'-'.$i;
        }

        return $slug;
    }

    public function slugFor(?string $lang = null): ?string
    {
        $lang ??= app(ActiveLocale::class)->language();
        $slugs = (array) $this->slug;

        return $slugs[$lang] ?? $slugs['sr'] ?? null;
    }

    public function scopeWhereSlug(Builder $query, string $slug): Builder
    {
        $lang = app(ActiveLocale::class)->language();

        if ($lang === 'sr') {
            return $query->where('slug->sr', $slug);
        }

        return $query->where(fn ($q) => $q
            ->where("slug->{$lang}", $slug)
            ->orWhere(fn ($rez) => $rez->where('slug->sr', $slug)->whereNull("slug->{$lang}")));
    }
}
