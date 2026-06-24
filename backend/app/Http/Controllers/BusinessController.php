<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusinessResource;
use App\Models\Business;
use Inertia\Inertia;
use Inertia\Response;

class BusinessController extends Controller
{
    public function index(): Response
    {
        $biznisi = Business::objavljeno()
            ->with(['category', 'media'])
            ->latest('published_at')
            ->get();

        return Inertia::render('LocalListing', [
            'biznisi' => BusinessResource::collection($biznisi),
        ]);
    }

    public function show(string $slug): Response
    {
        $biznis = Business::objavljeno()
            ->with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $slicni = Business::objavljeno()
            ->with(['category', 'media'])
            ->where('id', '!=', $biznis->id)
            ->where('category_id', $biznis->category_id)
            ->limit(3)
            ->get();

        return Inertia::render('BusinessProfile', [
            'slug' => $slug,
            'biznis' => new BusinessResource($biznis),
            'slicni' => BusinessResource::collection($slicni),
        ]);
    }
}
