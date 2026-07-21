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

class Story extends Model implements HasMedia
{
    use HasLocalizedContent, HasTranslatableSlug, InteractsWithMedia, TracksStatus, HasTags;

    public array $translatable = ['naslov', 'izvod', 'sadrzaj', 'autor', 'autor_bio'];

    protected $fillable = [
        'user_id',
        'category_id',
        'naslov',
        'slug',
        'izvod',
        'sadrzaj',
        'autor',
        'autor_bio',
        'datum',
        'featured',
        'status',
        'rejection_reason',
        'pending',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'datum' => 'date',
            'featured' => 'boolean',
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'slug' => 'array',
            'pending' => 'array',
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
        $this->addMediaCollection('naslovna_pending')->useDisk('local')->singleFile();
        $this->addMediaCollection('galerija_pending')->useDisk('local');
    }

    /** Primijeni ulazne podatke (format autorske forme) na živa polja. */
    public function popuniIz(array $data): void
    {
        $this->fill([
            'naslov' => $data['naslov'] ?? '',
            'category_id' => $data['category_id'] ?? null,
            'izvod' => $data['izvod'] ?? null,
            'sadrzaj' => $data['sadrzaj'] ?? null,
        ]);
    }

    /** Odobri izmjene na čekanju: prelij u živa polja, promoviši staging medije, obriši pending. */
    public function primijeniPending(): void
    {
        if (! $this->pending) {
            return;
        }

        $this->popuniIz($this->pending);
        $this->pending = null;
        $this->save();

        if ($this->getMedia('naslovna_pending')->isNotEmpty()) {
            $this->clearMediaCollection('naslovna');
            foreach ($this->getMedia('naslovna_pending') as $m) {
                $m->move($this, 'naslovna', 'public');
            }
        }

        foreach ($this->getMedia('galerija_pending') as $m) {
            $m->move($this, 'galerija', 'public');
        }
    }

    /** Odbaci izmjene na čekanju: obriši pending podatke i staging medije (živa verzija netaknuta). */
    public function odbaciPending(): void
    {
        $this->pending = null;
        $this->save();
        $this->clearMediaCollection('naslovna_pending');
        $this->clearMediaCollection('galerija_pending');
    }

    public function scopeObjavljeno(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Objavljeno);
    }
}
