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

class Procurement extends Model implements HasMedia
{
    use HasLocalizedContent, HasTranslatableSlug, InteractsWithMedia, TracksStatus, HasTags;

    protected $table = 'procurements';

    public array $translatable = ['naslov', 'opis'];

    protected $fillable = [
        'user_id',
        'naslov',
        'slug',
        'opis',
        'godina',
        'datum',
        'status',
        'rejection_reason',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'godina' => 'integer',
            'datum' => 'date',
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'slug' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('dokumenti');
    }

    public function scopeObjavljeno(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Objavljeno);
    }
}
