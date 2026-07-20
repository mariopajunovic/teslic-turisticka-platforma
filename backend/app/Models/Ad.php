<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\HasLocalizedContent;
use App\Models\Concerns\HasTags;
use App\Models\Concerns\HasTranslatableSlug;
use App\Models\Concerns\TracksStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ad extends Model implements HasMedia
{
    use HasLocalizedContent, HasTranslatableSlug, InteractsWithMedia, TracksStatus, HasTags;

    public array $translatable = ['naslov', 'izdavac', 'lokacija', 'opis_dug'];

    protected $fillable = [
        'user_id',
        'category_id',
        'naslov',
        'slug',
        'izdavac',
        'lokacija',
        'rok',
        'opis_dug',
        'kontakt',
        'status',
        'rejection_reason',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'kontakt' => 'array',
            'rok' => 'date',
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'slug' => 'array',
        ];
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
