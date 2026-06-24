<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Ad;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/oglasi.json');

        if (! is_file($path)) {
            return;
        }

        $items = json_decode(file_get_contents($path), true) ?? [];

        foreach ($items as $item) {
            $vrsta = $item['vrsta'] ?? [];
            $key = $vrsta['icon'] ?? Str::slug($vrsta['label'] ?? '');

            $category = Category::firstOrCreate(
                ['key' => $key],
                [
                    'label' => $vrsta['label'] ?? $key,
                    'icon' => $vrsta['icon'] ?? null,
                    'type' => 'oglasi',
                ],
            );

            $rok = null;
            if (! empty($item['rok'])) {
                try {
                    $rok = Carbon::createFromFormat('d.m.Y.', rtrim($item['rok'], ' '))->format('Y-m-d');
                } catch (\Throwable) {
                    $rok = null;
                }
            }

            Ad::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'user_id' => null,
                    'category_id' => $category->id,
                    'naslov' => $item['naslov'],
                    'izdavac' => $item['izdavac'] ?? null,
                    'lokacija' => $item['lokacija'] ?? null,
                    'rok' => $rok,
                    'opis_dug' => $item['opisDug'] ?? null,
                    'kontakt' => $item['kontakt'] ?? null,
                    'status' => ContentStatus::Objavljeno,
                    'published_at' => now(),
                ],
            );
        }
    }
}
