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

    public array $translatable = ['naslov', 'opis', 'opis_dug', 'lokacija', 'usluge'];

    protected $fillable = [
        'user_id',
        'category_id',
        'naslov',
        'slug',
        'opis',
        'opis_dug',
        'lokacija',
        'radno_vrijeme',
        'preporuceno',
        'kontakt',
        'drustvene',
        'usluge',
        'cijena_raspon',
        'godina_osnivanja',
        'jib',
        'nacin_placanja',
        'lat',
        'lng',
        'status',
        'rejection_reason',
        'pending',
        'pending_reason',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'array',
            'pending' => 'array',
            'kontakt' => 'array',
            'radno_vrijeme' => 'array',
            'drustvene' => 'array',
            'nacin_placanja' => 'array',
            'godina_osnivanja' => 'integer',
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

        if ($lang === 'sr') {
            return $query->where('slug->sr', $slug);
        }

        return $query->where(fn ($q) => $q
            ->where("slug->{$lang}", $slug)
            ->orWhere(fn ($rez) => $rez->where('slug->sr', $slug)->whereNull("slug->{$lang}")));
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
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('naslovna')->singleFile();
        $this->addMediaCollection('galerija');
        $this->addMediaCollection('naslovna_pending')->useDisk('local')->singleFile();
        $this->addMediaCollection('galerija_pending')->useDisk('local');
    }

    /** Primijeni ulazne podatke (format vlasničke forme) na živa polja. */
    public function popuniIz(array $data): void
    {
        $this->fill([
            'naslov' => $data['naslov'] ?? '',
            'category_id' => $data['category_id'] ?? null,
            'opis' => $data['opis'] ?? null,
            'opis_dug' => $data['opis_dug'] ?? null,
            'lokacija' => $data['lokacija'] ?? null,
            'kontakt' => $data['kontakt'] ?? null,
            'drustvene' => collect(['facebook', 'instagram', 'youtube', 'tiktok'])
                ->mapWithKeys(fn ($k) => [$k => trim((string) ($data['drustvene'][$k] ?? ''))])
                ->all(),
            'nacin_placanja' => array_filter([
                'gotovina' => (bool) ($data['nacin_placanja']['gotovina'] ?? false),
                'kartica' => (bool) ($data['nacin_placanja']['kartica'] ?? false),
                'virman' => (bool) ($data['nacin_placanja']['virman'] ?? false),
            ]),
            'cijena_raspon' => in_array($data['cijena_raspon'] ?? '', ['€', '€€', '€€€'], true) ? $data['cijena_raspon'] : null,
            'godina_osnivanja' => $data['godina_osnivanja'] ?? null,
            'jib' => $data['jib'] ?? null,
            'radno_vrijeme' => collect($data['radno_vrijeme'] ?? [])->take(7)->map(fn ($d) => [
                'zatvoreno' => (bool) ($d['zatvoreno'] ?? false),
                'od' => trim((string) ($d['od'] ?? '')),
                'do' => trim((string) ($d['do'] ?? '')),
            ])->values()->all(),
            'lat' => $data['lat'] ?? null,
            'lng' => $data['lng'] ?? null,
        ]);

        $this->setTranslations('usluge', ['sr' => collect(preg_split('/\r\n|\r|\n/', (string) ($data['usluge'] ?? '')))
            ->map(fn ($u) => trim($u))
            ->filter()
            ->values()
            ->all()]);
    }

    /** Odobri izmjene na čekanju: prelij u živa polja, promoviši staging medije, obriši pending. */
    public function primijeniPending(): void
    {
        if (! $this->pending) {
            return;
        }

        $this->popuniIz($this->pending);
        $this->pending = null;
        $this->pending_reason = null;
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

    /** Vrati izmjene vlasniku na doradu: zadrži pending, zapiši razlog (živa verzija netaknuta). */
    public function vratiPending(string $reason): void
    {
        if (! $this->pending) {
            return;
        }

        $this->pending_reason = $reason;
        $this->save();
    }

    /** Odbaci izmjene na čekanju: obriši pending podatke i staging medije (živa verzija netaknuta). */
    public function odbaciPending(): void
    {
        $this->pending = null;
        $this->pending_reason = null;
        $this->save();
        $this->clearMediaCollection('naslovna_pending');
        $this->clearMediaCollection('galerija_pending');
    }

    public function scopeObjavljeno(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Objavljeno);
    }
}
