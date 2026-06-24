<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Place extends Model
{
    protected $fillable = [
        'naziv',
        'lat',
        'lng',
        'category_id',
        'linkable_type',
        'linkable_id',
    ];

    protected function casts(): array
    {
        return [
            'lat' => 'float',
            'lng' => 'float',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }
}
