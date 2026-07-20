<?php

namespace App\Http\Controllers\Administracija;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdsController extends AdminResourceController
{
    protected function model(): string
    {
        return Ad::class;
    }

    protected function view(): string
    {
        return 'Oglasi';
    }

    protected function base(): string
    {
        return 'oglasi';
    }

    protected function categoryType(): string
    {
        return 'oglasi';
    }

    protected function tip(): string
    {
        return 'ad';
    }

    protected function nazivJednine(): string
    {
        return 'Oglas';
    }

    protected function propKey(): string
    {
        return 'oglas';
    }

    protected function hasMedia(): bool
    {
        return false;
    }

    protected const POLJA = ['izdavac', 'lokacija', 'opis_dug'];

    protected function rules(?Model $model): array
    {
        return [
            'izdavac' => ['array'],
            'izdavac.*' => ['nullable', 'string', 'max:255'],
            'lokacija' => ['array'],
            'lokacija.*' => ['nullable', 'string', 'max:255'],
            'opis_dug' => ['array'],
            'opis_dug.*' => ['nullable', 'string'],
            'rok' => ['nullable', 'date'],
            'kontakt' => ['array'],
            'kontakt.osoba' => ['nullable', 'string', 'max:255'],
            'kontakt.telefon' => ['nullable', 'string', 'max:100'],
            'kontakt.email' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function assign(Model $stavka, array $data): void
    {
        foreach (self::POLJA as $f) {
            $stavka->setTranslations($f, $this->trMap($data[$f] ?? []));
        }

        $stavka->rok = $data['rok'] ?? null;
        $stavka->kontakt = [
            'osoba' => trim((string) ($data['kontakt']['osoba'] ?? '')),
            'telefon' => trim((string) ($data['kontakt']['telefon'] ?? '')),
            'email' => trim((string) ($data['kontakt']['email'] ?? '')),
        ];
    }

    protected function detaljiExtra(Model $stavka): array
    {
        $out = [];
        foreach (self::POLJA as $f) {
            $out[$f] = $stavka->getTranslations($f);
        }
        $out['rok'] = $stavka->rok?->format('Y-m-d');
        $out['kontakt'] = (array) $stavka->kontakt;

        return $out;
    }

    protected function rowPodnaslov(Model $stavka): string
    {
        return trim(collect([
            $stavka->getTranslations('izdavac')['sr'] ?? '',
            $stavka->getTranslations('lokacija')['sr'] ?? '',
        ])->filter()->implode(' · '));
    }
}
