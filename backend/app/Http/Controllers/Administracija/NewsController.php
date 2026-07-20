<?php

namespace App\Http\Controllers\Administracija;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsController extends AdminResourceController
{
    protected function model(): string
    {
        return News::class;
    }

    protected function view(): string
    {
        return 'Vijesti';
    }

    protected function base(): string
    {
        return 'vijesti';
    }

    protected function categoryType(): string
    {
        return '';
    }

    protected function tip(): string
    {
        return 'news';
    }

    protected function nazivJednine(): string
    {
        return 'Vijest';
    }

    protected function propKey(): string
    {
        return 'vijest';
    }

    protected function hasCategory(): bool
    {
        return false;
    }

    protected const POLJA = ['izvod', 'sadrzaj'];

    protected function rules(?Model $model): array
    {
        return [
            'izvod' => ['array'],
            'izvod.*' => ['nullable', 'string', 'max:1000'],
            'sadrzaj' => ['array'],
            'sadrzaj.*' => ['nullable', 'string'],
            'datum' => ['nullable', 'date'],
        ];
    }

    protected function assign(Model $stavka, array $data): void
    {
        foreach (self::POLJA as $f) {
            $stavka->setTranslations($f, $this->trMap($data[$f] ?? []));
        }

        $stavka->datum = $data['datum'] ?? null;
    }

    protected function detaljiExtra(Model $stavka): array
    {
        $out = [];
        foreach (self::POLJA as $f) {
            $out[$f] = $stavka->getTranslations($f);
        }
        $out['datum'] = $stavka->datum?->format('Y-m-d');

        return $out;
    }

    protected function rowPodnaslov(Model $stavka): string
    {
        return Str::limit(strip_tags($stavka->getTranslations('izvod')['sr'] ?? ''), 80);
    }
}
