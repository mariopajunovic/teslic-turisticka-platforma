<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use App\Support\ActiveLocale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'key',
        'slug',
        'label',
        'opis',
        'hero_image',
        'meta_title',
        'meta_description',
        'icon',
        'color',
        'type',
        'sort',
        'visible',
    ];

    public array $translatable = ['label', 'opis', 'meta_title', 'meta_description'];

    protected function casts(): array
    {
        return [
            'slug' => 'array',
            'sort' => 'integer',
            'visible' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $model): void {
            $slugs = (array) $model->slug;
            $labeli = json_decode($model->attributes['label'] ?? '{}', true) ?: [];

            $jezici = array_unique(array_merge(array_keys($labeli), array_keys($slugs)));
            if (! in_array('sr', $jezici, true)) {
                $jezici[] = 'sr';
            }

            foreach ($jezici as $lang) {
                $osnova = $slugs[$lang] ?? '';

                if ($osnova === '' && ! empty($labeli[$lang])) {
                    $osnova = Str::slug($labeli[$lang]);
                }

                if ($osnova !== '') {
                    $slugs[$lang] = $model->jedinstvenSlug($osnova, $lang);
                }
            }

            $model->slug = $slugs;

            if (empty($model->key) && ! empty($slugs['sr'])) {
                $model->key = $model->jedinstvenKey($slugs['sr']);
            }
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

    protected function jedinstvenKey(string $osnova): string
    {
        $key = $osnova;
        $i = 1;

        while (static::query()
            ->where('key', $key)
            ->when($this->id, fn ($q) => $q->where('id', '!=', $this->id))
            ->exists()) {
            $i++;
            $key = $osnova.'-'.$i;
        }

        return $key;
    }

    public function slugFor(?string $lang = null): ?string
    {
        $lang ??= app(ActiveLocale::class)->language();
        $slugs = (array) $this->slug;

        return $slugs[$lang] ?? $slugs['sr'] ?? $this->key;
    }

    public function scopeByKeyOrSlug(Builder $query, string $vrijednost): Builder
    {
        $lang = app(ActiveLocale::class)->language();

        return $query->where(fn ($q) => $q
            ->where('key', $vrijednost)
            ->orWhere("slug->{$lang}", $vrijednost)
            ->orWhere('slug->sr', $vrijednost));
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }
}
