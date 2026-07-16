<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use HasLocalizedContent, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'published',
        'is_system',
        'meta_title',
        'meta_description',
        'sort',
    ];

    public array $translatable = ['title', 'content', 'meta_title', 'meta_description'];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'is_system' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }
}
