<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Story;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\Concerns\SeedsMedia;
use Database\Seeders\Concerns\VariesStatus;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    use SeedsMedia;
    use VariesStatus;

    protected const LABEL_TO_KEY = [
        'Izdvojeno' => 'izdvojeno',
        'Domaćini pričaju' => 'domacini',
        'Ljudi i biznisi' => 'ljudi',
        'Naša svakodnevica' => 'svakodnevica',
    ];

    public function run(): void
    {
        $path = database_path('data/price.json');

        if (! is_file($path)) {
            return;
        }

        $owner = User::where('email', 'autor@komteldoo.com')->first();
        $items = json_decode(file_get_contents($path), true) ?? [];

        foreach ($items as $i => $item) {
            $label = $item['kategorija']['label'] ?? null;
            $key = self::LABEL_TO_KEY[$label] ?? 'izdvojeno';
            $category = Category::where('key', $key)->first();

            $datum = $this->parseDate($item['datum'] ?? null);

            $model = Story::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'user_id' => $owner?->id,
                    'category_id' => $category?->id,
                    'naslov' => $item['naslov'],
                    'izvod' => $item['izvod'] ?? null,
                    'sadrzaj' => $item['sadrzaj'] ?? null,
                    'autor' => $item['autor'] ?? null,
                    'autor_bio' => $item['autorBio'] ?? null,
                    'datum' => $datum,
                    'featured' => $item['featured'] ?? false,
                    ...$this->statusFields($i),
                ],
            );

            $this->attachSlika($model, $item['slika'] ?? null);
        }
    }

    protected function parseDate(?string $raw): ?Carbon
    {
        if (! $raw) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d.m.Y.', rtrim($raw, ' '));
        } catch (\Throwable) {
            return null;
        }
    }
}
