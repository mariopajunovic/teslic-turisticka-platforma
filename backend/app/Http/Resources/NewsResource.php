<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slugFor(),
            'url' => \App\Support\ResourceUrls::detail($this->resource),
            'naslov' => $this->naslov,
            'izvod' => $this->izvod,
            'sadrzaj' => $this->sadrzaj,
            'datum' => $this->datum?->format('d.m.Y.'),
            'datumIso' => $this->datum?->format('Y-m-d'),
            'slika' => $this->getFirstMediaUrl('naslovna') ?: null,
            'galerija' => $this->getMedia('galerija')
                ->map(fn ($m) => ['src' => $m->getUrl(), 'alt' => $m->name])
                ->values(),
        ];
    }
}
