<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use App\Support\ActiveLocale;
use App\Support\ResourceUrls;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasLocalizedContent;

    public const CILJ_STRANICA = 'page';

    public const CILJ_KATEGORIJA = 'category';

    public const CILJ_VANJSKI = 'external';

    protected $fillable = ['menu_id', 'parent_id', 'label', 'target_type', 'target_id', 'url', 'sort', 'visible'];

    public array $translatable = ['label'];

    protected function casts(): array
    {
        return [
            'visible' => 'boolean',
        ];
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort');
    }

    public function tipCilja(): string
    {
        return $this->target_type ?: self::CILJ_VANJSKI;
    }

    public function razrijeseniUrl(?string $lang = null): ?string
    {
        return match ($this->target_type) {
            self::CILJ_STRANICA => $this->stranicaUrl($lang),
            self::CILJ_KATEGORIJA => $this->kategorijaUrl($lang),
            default => $this->url ?: null,
        };
    }

    public function mrtav(): bool
    {
        return $this->razrijeseniUrl() === null;
    }

    protected function stranicaUrl(?string $lang): ?string
    {
        $stranica = Page::find($this->target_id);

        if (! $stranica || ! $stranica->published) {
            return null;
        }

        $locale = app(ActiveLocale::class);

        return $locale->path($stranica->pathFor($lang), $lang ?? $locale->language());
    }

    protected function kategorijaUrl(?string $lang): ?string
    {
        $kategorija = Category::find($this->target_id);

        return $kategorija ? ResourceUrls::category($kategorija, $lang) : null;
    }
}
