<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'naslov' => $this->naslov,
            'kategorija' => $this->category ? [
                'key' => $this->category->key,
                'label' => $this->category->label,
                'icon' => $this->category->icon,
            ] : null,
            'autor' => $this->autor,
            'autorBio' => $this->autor_bio,
            'datum' => $this->datum?->format('d.m.Y.'),
            'izvod' => $this->izvod,
            'sadrzaj' => $this->sadrzaj,
            'featured' => (bool) $this->featured,
            'slika' => $this->getFirstMediaUrl('naslovna'),
            'galerija' => $this->getMedia('galerija')
                ->map(fn ($m) => ['src' => $m->getUrl(), 'alt' => $m->name])
                ->values(),
        ];
    }
}
