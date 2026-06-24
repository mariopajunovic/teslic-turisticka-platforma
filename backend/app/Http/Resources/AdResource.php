<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'naslov' => $this->naslov,
            'vrsta' => $this->category ? [
                'label' => $this->category->label,
                'icon' => $this->category->icon,
            ] : null,
            'izdavac' => $this->izdavac,
            'lokacija' => $this->lokacija,
            'rok' => $this->rok?->format('d.m.Y.'),
            'isteklo' => $this->rok ? $this->rok->isPast() : false,
            'opisDug' => $this->opis_dug,
            'kontakt' => $this->kontakt ?? (object) [],
        ];
    }
}
