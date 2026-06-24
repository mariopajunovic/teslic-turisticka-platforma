<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Location;
use Inertia\Inertia;
use Inertia\Response;

class LocationController extends Controller
{
    public function index(): Response
    {
        $lokaliteti = Location::objavljeno()
            ->with(['category', 'media'])
            ->latest('published_at')
            ->get();

        return Inertia::render('TourismListing', [
            'lokaliteti' => LocationResource::collection($lokaliteti),
        ]);
    }

    public function show(string $slug): Response
    {
        $lokalitet = Location::objavljeno()
            ->with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $slicni = Location::objavljeno()
            ->with(['category', 'media'])
            ->where('id', '!=', $lokalitet->id)
            ->limit(3)
            ->get();

        return Inertia::render('LocationDetail', [
            'slug' => $slug,
            'lokalitet' => new LocationResource($lokalitet),
            'slicni' => LocationResource::collection($slicni),
        ]);
    }
}
