<?php

namespace App\Http\Controllers\Administracija;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;

class EventsController extends AdminResourceController
{
    protected function model(): string
    {
        return Event::class;
    }

    protected function view(): string
    {
        return 'Dogadjaji';
    }

    protected function base(): string
    {
        return 'dogadjaji';
    }

    protected function categoryType(): string
    {
        return 'dogadjaj';
    }

    protected function tip(): string
    {
        return 'event';
    }

    protected function nazivJednine(): string
    {
        return 'Događaj';
    }

    protected function propKey(): string
    {
        return 'dogadjaj';
    }

    protected const POLJA = ['opis', 'opis_dug', 'lokacija', 'organizator'];

    protected function rules(?Model $model): array
    {
        return [
            'opis' => ['array'],
            'opis.*' => ['nullable', 'string', 'max:1000'],
            'opis_dug' => ['array'],
            'opis_dug.*' => ['nullable', 'string'],
            'lokacija' => ['array'],
            'lokacija.*' => ['nullable', 'string', 'max:255'],
            'organizator' => ['array'],
            'organizator.*' => ['nullable', 'string', 'max:255'],
            'datum' => ['nullable', 'date'],
            'vrijeme' => ['nullable', 'string', 'max:100'],
            'zavrseno' => ['boolean'],
            'lat' => ['nullable', 'numeric', 'between:-90,90'],
            'lng' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }

    protected function assign(Model $stavka, array $data): void
    {
        foreach (self::POLJA as $f) {
            $stavka->setTranslations($f, $this->trMap($data[$f] ?? []));
        }

        $stavka->datum = $data['datum'] ?? null;
        $stavka->vrijeme = trim((string) ($data['vrijeme'] ?? '')) ?: null;
        $stavka->zavrseno = (bool) ($data['zavrseno'] ?? false);
        $stavka->lat = $data['lat'] ?? null;
        $stavka->lng = $data['lng'] ?? null;
    }

    protected function detaljiExtra(Model $stavka): array
    {
        $out = [];
        foreach (self::POLJA as $f) {
            $out[$f] = $stavka->getTranslations($f);
        }
        $out['datum'] = $stavka->datum?->format('Y-m-d');
        $out['vrijeme'] = $stavka->vrijeme;
        $out['zavrseno'] = (bool) $stavka->zavrseno;
        $out['lat'] = $stavka->lat;
        $out['lng'] = $stavka->lng;

        return $out;
    }

    protected function rowPodnaslov(Model $stavka): string
    {
        return trim(collect([
            $stavka->datum?->translatedFormat('d.m.Y.'),
            $stavka->getTranslations('lokacija')['sr'] ?? '',
        ])->filter()->implode(' · '));
    }
}
