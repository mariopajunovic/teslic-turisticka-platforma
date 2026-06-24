<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\TracksStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Business extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia, TracksStatus;

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
            'kontakt' => 'array',
            'preporuceno' => 'boolean',
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'lat' => 'float',
            'lng' => 'float',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('naslov')
            ->saveSlugsTo('slug');
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
