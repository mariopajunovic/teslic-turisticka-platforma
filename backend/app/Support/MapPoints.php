<?php

namespace App\Support;

use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Support\ResourceUrls;

class MapPoints
{
    public static function all(): array
    {
        return collect()
            ->merge(self::points(Business::class, null))
            ->merge(self::points(Location::class, null))
            ->merge(self::points(Event::class, 'dogadjaj'))
            ->values()
            ->all();
    }

    protected static function points(string $model, ?string $fallbackKey): array
    {
        return $model::objavljeno()
            ->with(['category', 'media'])
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get()
            ->map(function ($r) use ($fallbackKey) {
                $slug = method_exists($r, 'slugFor') ? $r->slugFor() : $r->slug;

                return [
                    'slug' => $slug,
                    'naslov' => $r->naslov,
                    'kategorija' => $r->category?->key ?? $fallbackKey,
                    'lokacija' => $r->lokacija,
                    'slika' => $r->getFirstMediaUrl('naslovna'),
                    'lat' => (float) $r->lat,
                    'lng' => (float) $r->lng,
                    'to' => ResourceUrls::detail($r),
                ];
            })
            ->all();
    }
}
