<?php

namespace App\Support;

use App\Enums\ContentStatus;
use App\Models\Ad;
use App\Models\Business;
use App\Models\ContentLink;
use App\Models\Event;
use App\Models\Location;
use App\Models\Story;
use Illuminate\Database\Eloquent\Model;
use App\Support\ResourceUrls;

class RelatedLinks
{
    protected const ROUTES = [
        Business::class => 'Biznis',
        Location::class => 'Lokalitet',
        Event::class => 'Događaj',
        Ad::class => 'Oglas',
        Story::class => 'Priča',
    ];

    public static function for(Model $model): array
    {
        $type = $model::class;
        $id = $model->getKey();

        $links = ContentLink::query()
            ->where(fn ($q) => $q->where('source_type', $type)->where('source_id', $id))
            ->orWhere(fn ($q) => $q->where('target_type', $type)->where('target_id', $id))
            ->get();

        $items = [];

        foreach ($links as $link) {
            $isSource = $link->source_type === $type && (int) $link->source_id === (int) $id;
            $otherType = $isSource ? $link->target_type : $link->source_type;
            $otherId = $isSource ? $link->target_id : $link->source_id;

            if (! isset(self::ROUTES[$otherType])) {
                continue;
            }

            $related = $otherType::find($otherId);

            if (! $related || $related->status !== ContentStatus::Objavljeno) {
                continue;
            }

            $label = self::ROUTES[$otherType];

            $items[] = [
                'naslov' => $related->naslov,
                'tip' => $label,
                'to' => ResourceUrls::detail($related),
                'slika' => $related->getFirstMediaUrl('naslovna'),
            ];
        }

        return $items;
    }
}
