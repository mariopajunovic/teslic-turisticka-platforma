<?php

namespace App\Http\Controllers\Administracija;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LocationsController extends AdminResourceController
{
    protected function model(): string
    {
        return Location::class;
    }

    protected function view(): string
    {
        return 'Turizam';
    }

    protected function base(): string
    {
        return 'turizam';
    }

    protected function categoryType(): string
    {
        return 'turizam';
    }

    protected function tip(): string
    {
        return 'location';
    }

    protected function nazivJednine(): string
    {
        return 'Lokalitet';
    }

    protected function propKey(): string
    {
        return 'lokalitet';
    }

    protected const POLJA = ['opis', 'opis_dug', 'lokacija', 'kako_doci', 'savjeti', 'sezona', 'radno_vrijeme', 'ulaznice'];

    protected function rules(?Model $model): array
    {
        return [
            'opis' => ['array'],
            'opis.*' => ['nullable', 'string', 'max:1000'],
            'opis_dug' => ['array'],
            'opis_dug.*' => ['nullable', 'string'],
            'lokacija' => ['array'],
            'lokacija.*' => ['nullable', 'string', 'max:255'],
            'kako_doci' => ['array'],
            'kako_doci.*' => ['nullable', 'string'],
            'savjeti' => ['array'],
            'savjeti.*' => ['nullable', 'string'],
            'sezona' => ['array'],
            'sezona.*' => ['nullable', 'string', 'max:255'],
            'radno_vrijeme' => ['array'],
            'radno_vrijeme.*' => ['nullable', 'string', 'max:255'],
            'ulaznice' => ['array'],
            'ulaznice.*' => ['nullable', 'string', 'max:255'],
            'lat' => ['nullable', 'numeric', 'between:-90,90'],
            'lng' => ['nullable', 'numeric', 'between:-180,180'],
            'preporuceno' => ['boolean'],
        ];
    }

    protected function assign(Model $stavka, array $data): void
    {
        foreach (self::POLJA as $f) {
            $stavka->setTranslations($f, $this->trMap($data[$f] ?? []));
        }

        $stavka->lat = $data['lat'] ?? null;
        $stavka->lng = $data['lng'] ?? null;
        $stavka->preporuceno = (bool) ($data['preporuceno'] ?? false);
    }

    protected function detaljiExtra(Model $stavka): array
    {
        $out = [];
        foreach (self::POLJA as $f) {
            $out[$f] = $stavka->getTranslations($f);
        }
        $out['lat'] = $stavka->lat;
        $out['lng'] = $stavka->lng;
        $out['preporuceno'] = (bool) $stavka->preporuceno;

        return $out;
    }

    protected function rowPodnaslov(Model $stavka): string
    {
        return Str::limit(strip_tags($stavka->getTranslations('opis')['sr'] ?? ''), 80)
            ?: ($stavka->getTranslations('lokacija')['sr'] ?? '');
    }
}
