<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProcurementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slugFor(),
            'url' => \App\Support\ResourceUrls::detail($this->resource),
            'naslov' => $this->naslov,
            'opis' => $this->opis,
            'godina' => $this->godina,
            'datum' => $this->datum?->format('d.m.Y.'),
            'dokumenti' => $this->getMedia('dokumenti')->map(fn (Media $m) => [
                'naziv' => $m->name ?: $m->file_name,
                'url' => $m->getUrl(),
                'velicina' => $this->velicina($m->size),
            ])->values(),
        ];
    }

    protected function velicina(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        return max(1, (int) round($bytes / 1024)).' KB';
    }
}
