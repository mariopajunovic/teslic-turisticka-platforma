<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'naslov' => $this->naslov,
            'opis' => $this->opis,
            'opisDug' => $this->opis_dug,
            'lokacija' => $this->lokacija,
            'preporuceno' => (bool) $this->preporuceno,
            'kategorija' => $this->category ? [
                'key' => $this->category->key,
                'label' => $this->category->label,
                'icon' => $this->category->icon,
            ] : null,
            'kakoDoci' => $this->kako_doci,
            'savjeti' => $this->savjeti,
            'sezona' => $this->sezona,
            'radnoVrijeme' => $this->radno_vrijeme,
            'ulaznice' => $this->ulaznice,
            'slika' => $this->getFirstMediaUrl('naslovna'),
            'galerija' => $this->getMedia('galerija')
                ->map(fn ($m) => ['src' => $m->getUrl(), 'alt' => $m->name])
                ->values(),
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }
}
