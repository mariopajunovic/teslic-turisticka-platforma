<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalBlock extends Model
{
    protected $table = 'global_blocks';

    protected $fillable = ['name', 'type', 'data'];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
