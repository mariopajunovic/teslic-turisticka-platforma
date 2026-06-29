<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
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

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }
}
