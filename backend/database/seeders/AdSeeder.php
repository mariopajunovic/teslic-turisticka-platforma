<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Category;
use Carbon\Carbon;
use Database\Seeders\Concerns\SeedsMedia;
use Database\Seeders\Concerns\VariesStatus;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    use SeedsMedia;
    use VariesStatus;

    protected const LABEL_TO_KEY = [
        'Posao' => 'posao',
        'Nekretnine' => 'nekretnine',
        'Javni poziv' => 'poziv',
        'Ponuda' => 'poziv',
    ];

    public function run(): void
    {
        $path = database_path('data/oglasi.json');

        if (! is_file($path)) {
            return;
        }

        $items = json_decode(file_get_contents($path), true) ?? [];

        foreach ($items as $i => $item) {
            $label = $item['vrsta']['label'] ?? null;
            $key = self::LABEL_TO_KEY[$label] ?? 'poziv';
            $category = Category::where('key', $key)->first();

            $rok = null;
            if (! empty($item['rok'])) {
                try {
                    $rok = Carbon::createFromFormat('d.m.Y.', rtrim($item['rok'], ' '))->format('Y-m-d');
                } catch (\Throwable) {
                    $rok = null;
                }
            }

            $model = Ad::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'user_id' => null,
                    'category_id' => $category?->id,
                    'naslov' => $item['naslov'],
                    'izdavac' => $item['izdavac'] ?? null,
                    'lokacija' => $item['lokacija'] ?? null,
                    'rok' => $rok,
                    'opis_dug' => $item['opisDug'] ?? null,
                    'kontakt' => $item['kontakt'] ?? null,
                    ...$this->statusFields($i),
                ],
            );

            $this->attachSlika($model, $item['slika'] ?? null);
        }
    }
}
