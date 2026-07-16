<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'group',
        'key',
        'values',
    ];

    protected function casts(): array
    {
        return [
            'values' => 'array',
        ];
    }
}
