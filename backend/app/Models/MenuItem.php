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

    public const CILJ_GRUPA = 'group';

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
        return ResourceUrls::forTarget([
            'type' => $this->target_type,
            'id' => $this->target_id,
            'url' => $this->url,
        ], $lang);
    }

    public function mrtav(): bool
    {
        return $this->razrijeseniUrl() === null;
    }


}
