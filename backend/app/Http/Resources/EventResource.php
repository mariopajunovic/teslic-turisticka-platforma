<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $mjeseci = ['', 'JAN', 'FEB', 'MAR', 'APR', 'MAJ', 'JUN', 'JUL', 'AVG', 'SEP', 'OKT', 'NOV', 'DEC'];

        return [
            'slug' => $this->slug,
            'naslov' => $this->naslov,
            'dan' => $this->datum?->format('d'),
            'mjesec' => $this->datum ? $mjeseci[(int) $this->datum->format('n')] : null,
            'datum' => $this->datum?->format('d.m.Y.'),
            'vrijeme' => $this->vrijeme,
            'lokacija' => $this->lokacija,
            'organizator' => $this->organizator,
            'opisDug' => $this->opis_dug,
            'zavrseno' => (bool) $this->zavrseno,
            'slika' => $this->getFirstMediaUrl('naslovna'),
            'galerija' => $this->getMedia('galerija')
                ->map(fn ($m) => ['src' => $m->getUrl(), 'alt' => $m->name])
                ->values(),
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }
}
