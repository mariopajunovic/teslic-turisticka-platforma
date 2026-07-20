<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slugFor(),
            'url' => \App\Support\ResourceUrls::detail($this->resource),
            'naslov' => $this->naslov,
            'opis' => $this->opis,
            'opisDug' => $this->opis_dug,
            'lokacija' => $this->lokacija,
            'radnoVrijeme' => $this->radno_vrijeme,
            'preporuceno' => (bool) $this->preporuceno,
            'kategorija' => $this->category ? [
                'key' => $this->category->key,
                'label' => $this->category->label,
                'icon' => $this->category->icon,
            ] : null,
            'logo' => $this->getFirstMediaUrl('logo') ?: null,
            'slika' => $this->getFirstMediaUrl('naslovna'),
            'galerija' => $this->getMedia('galerija')
                ->map(fn ($m) => ['src' => $m->getUrl(), 'alt' => $m->name])
                ->values(),
            'kontakt' => $this->kontakt ?? (object) [],
            'drustvene' => array_filter((array) $this->drustvene),
            'usluge' => (array) $this->usluge,
            'cijenaRaspon' => $this->cijena_raspon,
            'godinaOsnivanja' => $this->godina_osnivanja,
            'jib' => $this->jib,
            'nacinPlacanja' => array_keys(array_filter((array) $this->nacin_placanja)),
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }
}
