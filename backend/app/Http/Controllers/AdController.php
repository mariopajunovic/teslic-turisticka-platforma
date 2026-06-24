<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdResource;
use App\Models\Ad;
use Inertia\Inertia;
use Inertia\Response;

class AdController extends Controller
{
    public function index(): Response
    {
        $oglasi = Ad::objavljeno()
            ->with(['category'])
            ->latest('published_at')
            ->get();

        return Inertia::render('AdsListing', [
            'oglasi' => AdResource::collection($oglasi),
        ]);
    }

    public function show(string $slug): Response
    {
        $oglas = Ad::objavljeno()
            ->with(['category'])
            ->where('slug', $slug)
            ->firstOrFail();

        $slicni = Ad::objavljeno()
            ->with(['category'])
            ->where('id', '!=', $oglas->id)
            ->where('category_id', $oglas->category_id)
            ->limit(3)
            ->get();

        return Inertia::render('AdDetail', [
            'slug' => $slug,
            'oglas' => new AdResource($oglas),
            'slicni' => AdResource::collection($slicni),
        ]);
    }
}
