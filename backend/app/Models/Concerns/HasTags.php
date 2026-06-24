<?php

namespace App\Models\Concerns;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait HasTags
{
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function relatedContent(): Collection
    {
        $links = DB::table('content_links')
            ->where('source_type', static::class)
            ->where('source_id', $this->getKey())
            ->get();

        return $links;
    }
}
