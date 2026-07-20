<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\HasLocalizedContent;
use App\Models\Concerns\HasTags;
use App\Models\Concerns\TracksStatus;
use App\Support\ActiveLocale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Business extends Model implements HasMedia
{
    use HasLocalizedContent, InteractsWithMedia, TracksStatus, HasTags;

    public array $translatable = ['naslov', 'opis', 'opis_dug', 'lokacija'];

    protected $fillable = [
        'user_id',
        'category_id',
        'naslov',
        'slug',
        'opis',
        'opis_dug',
        'lokacija',
        'preporuceno',
        'kontakt',
        'lat',
        'lng',
        'status',
        'rejection_reason',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'array',
            'kontakt' => 'array',
            'preporuceno' => 'boolean',
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'lat' => 'float',
            'lng' => 'float',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $model): void {
            $slugs = (array) $model->slug;
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

        return $query->where(fn ($q) => $q->where("slug->{$lang}", $slug)->orWhere('slug->sr', $slug));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('naslovna')->singleFile();
        $this->addMediaCollection('galerija');
    }

    public function scopeObjavljeno(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Objavljeno);
    }
}
