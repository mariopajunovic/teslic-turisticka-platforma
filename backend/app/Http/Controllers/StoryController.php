<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoryResource;
use App\Models\Story;
use Inertia\Inertia;
use Inertia\Response;

class StoryController extends Controller
{
    public function index(): Response
    {
        $price = Story::objavljeno()
            ->with(['category', 'media'])
            ->latest('published_at')
            ->get();

        return Inertia::render('StoriesListing', [
            'price' => StoryResource::collection($price),
        ]);
    }

    public function show(string $slug): Response
    {
        $prica = Story::objavljeno()
            ->with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $slicne = Story::objavljeno()
            ->with(['category', 'media'])
            ->where('id', '!=', $prica->id)
            ->limit(3)
            ->get();

        return Inertia::render('StoryDetail', [
            'slug' => $slug,
            'prica' => new StoryResource($prica),
            'slicne' => StoryResource::collection($slicne),
        ]);
    }
}
