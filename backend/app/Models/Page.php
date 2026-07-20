<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use App\Support\ActiveLocale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'content',
        'published',
        'is_system',
        'resource_type',
        'category_id',
        'meta_title',
        'meta_description',
        'og_image',
        'sort',
    ];

    public array $translatable = ['title', 'meta_title', 'meta_description'];

    protected function casts(): array
    {
        return [
            'slug' => 'array',
            'content' => 'array',
            'published' => 'boolean',
            'is_system' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $model): void {
            $slugs = (array) $model->slug;
            $naslovi = json_decode($model->attributes['title'] ?? '{}', true) ?: [];

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
                    $slugs[$lang] = $model->jedinstvenSlug($osnova, $lang);
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
            ->where('parent_id', $this->parent_id)
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

    public function isHome(): bool
    {
        return (($this->slug['sr'] ?? null) === 'pocetna');
    }

    public function pathFor(?string $lang = null): string
    {
        if ($this->isHome()) {
            return '/';
        }

        $segmenti = [];

        if ($this->parent_id) {
            $roditelj = $this->relationLoaded('parent') ? $this->parent : $this->parent()->first();

            if ($roditelj && ! $roditelj->isHome()) {
                $segmenti[] = $roditelj->slugFor($lang);
            }
        }

        $segmenti[] = $this->slugFor($lang);

        return '/'.implode('/', array_filter($segmenti));
    }

    public function scopeWhereSlug(Builder $query, string $slug): Builder
    {
        $lang = app(ActiveLocale::class)->language();

        return $query->where(fn ($q) => $q->where("slug->{$lang}", $slug)->orWhere('slug->sr', $slug));
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort')->orderBy('id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
