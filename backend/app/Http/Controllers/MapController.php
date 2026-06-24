<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use Inertia\Inertia;
use Inertia\Response;

class MapController extends Controller
{
    public function index(): Response
    {
        $tacke = collect()
            ->merge($this->points(Business::class, '/domace-je-najbolje/', null))
            ->merge($this->points(Location::class, '/turizam/', null))
            ->merge($this->points(Event::class, '/dogadjaji/', 'dogadjaj'))
            ->values();

        return Inertia::render('Map', [
            'tacke' => $tacke,
        ]);
    }

    protected function points(string $model, string $prefix, ?string $fallbackKey): array
    {
        return $model::objavljeno()
            ->with(['category', 'media'])
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get()
            ->map(fn ($r) => [
                'slug' => $r->slug,
                'naslov' => $r->naslov,
                'kategorija' => $r->category?->key ?? $fallbackKey,
                'lokacija' => $r->lokacija,
                'slika' => $r->getFirstMediaUrl('naslovna'),
                'lat' => (float) $r->lat,
                'lng' => (float) $r->lng,
                'to' => $prefix.$r->slug,
            ])
            ->all();
    }
}
