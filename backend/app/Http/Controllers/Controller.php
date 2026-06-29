<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    protected function categoryHero(Category $cat): ?string
    {
        if (! $cat->hero_image) {
            return null;
        }

        return str_starts_with($cat->hero_image, 'http')
            ? $cat->hero_image
            : Storage::disk('public')->url($cat->hero_image);
    }
}
