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

class Event extends Model implements HasMedia
{
    use HasLocalizedContent, HasTranslatableSlug, InteractsWithMedia, TracksStatus, HasTags;

    public array $translatable = ['naslov', 'opis', 'opis_dug', 'lokacija', 'organizator'];

    protected $fillable = [
        'user_id',
        'category_id',
        'naslov',
        'slug',
        'opis',
        'opis_dug',
        'lokacija',
        'organizator',
        'datum',
        'vrijeme',
        'zavrseno',
        'lat',
        'lng',
        'status',
        'rejection_reason',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'datum' => 'date',
            'zavrseno' => 'boolean',
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'slug' => 'array',
            'lat' => 'float',
            'lng' => 'float',
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
