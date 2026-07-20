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

class Location extends Model implements HasMedia
{
    use HasLocalizedContent, HasTranslatableSlug, InteractsWithMedia, TracksStatus, HasTags;

    public array $translatable = ['naslov', 'opis', 'opis_dug', 'lokacija', 'kako_doci', 'savjeti', 'sezona', 'radno_vrijeme', 'ulaznice'];

    protected $fillable = [
        'user_id',
        'category_id',
        'naslov',
        'slug',
        'opis',
        'opis_dug',
        'lokacija',
        'preporuceno',
        'kako_doci',
        'savjeti',
        'sezona',
        'radno_vrijeme',
        'ulaznice',
        'lat',
        'lng',
        'status',
        'rejection_reason',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'preporuceno' => 'boolean',
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'lat' => 'float',
            'lng' => 'float',
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
