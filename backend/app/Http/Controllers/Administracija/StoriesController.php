<?php

namespace App\Http\Controllers\Administracija;

use App\Models\Story;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoriesController extends AdminResourceController
{
    protected function model(): string
    {
        return Story::class;
    }

    protected function view(): string
    {
        return 'Price';
    }

    protected function base(): string
    {
        return 'price';
    }

    protected function categoryType(): string
    {
        return 'price';
    }

    protected function tip(): string
    {
        return 'story';
    }

    protected function nazivJednine(): string
    {
        return 'Priča';
    }

    protected function propKey(): string
    {
        return 'prica';
    }

    protected const POLJA = ['izvod', 'sadrzaj', 'autor', 'autor_bio'];

    protected function pendingPolja(): array
    {
        return ['naslov' => 'Naslov', 'izvod' => 'Izvod', 'sadrzaj' => 'Sadržaj'];
    }

    protected function rules(?Model $model): array
    {
        return [
            'izvod' => ['array'],
            'izvod.*' => ['nullable', 'string', 'max:1000'],
            'sadrzaj' => ['array'],
            'sadrzaj.*' => ['nullable', 'string'],
            'autor' => ['array'],
            'autor.*' => ['nullable', 'string', 'max:255'],
            'autor_bio' => ['array'],
            'autor_bio.*' => ['nullable', 'string', 'max:1000'],
            'datum' => ['nullable', 'date'],
            'featured' => ['boolean'],
        ];
    }

    protected function assign(Model $stavka, array $data): void
    {
        foreach (self::POLJA as $f) {
            $stavka->setTranslations($f, $this->trMap($data[$f] ?? []));
        }

        $stavka->datum = $data['datum'] ?? null;
        $stavka->featured = (bool) ($data['featured'] ?? false);
    }

    protected function detaljiExtra(Model $stavka): array
    {
        $out = [];
        foreach (self::POLJA as $f) {
            $out[$f] = $stavka->getTranslations($f);
        }
        $out['datum'] = $stavka->datum?->format('Y-m-d');
        $out['featured'] = (bool) $stavka->featured;

        return $out;
    }

    protected function rowPodnaslov(Model $stavka): string
    {
        return Str::limit(strip_tags($stavka->getTranslations('izvod')['sr'] ?? ''), 80)
            ?: ($stavka->getTranslations('autor')['sr'] ?? '');
    }
}
