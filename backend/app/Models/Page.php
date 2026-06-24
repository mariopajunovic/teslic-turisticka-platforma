<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use HasSlug;

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

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'published' => 'boolean',
            'is_system' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }
}
