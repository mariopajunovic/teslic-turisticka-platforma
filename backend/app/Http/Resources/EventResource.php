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
            'url' => \App\Support\ResourceUrls::detail($this->resource),
            'naslov' => $this->naslov,
            'kategorija' => $this->category ? [
                'key' => $this->category->key,
                'label' => $this->category->label,
                'icon' => $this->category->icon,
            ] : null,
            'dan' => $this->datum?->format('d'),
            'mjesec' => $this->datum ? $mjeseci[(int) $this->datum->format('n')] : null,
            'datum' => $this->datum?->format('d.m.Y.'),
            'datumIso' => $this->datum?->format('Y-m-d'),
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
