<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'key',
        'label',
        'opis',
        'hero_image',
        'meta_title',
        'meta_description',
        'icon',
        'color',
        'type',
        'sort',
    ];

    public array $translatable = ['label', 'opis', 'meta_title', 'meta_description'];

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }
}
