<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use Database\Seeders\Concerns\VariesStatus;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    use VariesStatus;

    public function run(): void
    {
        $path = database_path('data/dogadjaji.json');

        if (! is_file($path)) {
            return;
        }

        $category = Category::where('key', 'dogadjaj')->first();
        $items = json_decode(file_get_contents($path), true) ?? [];

        foreach ($items as $i => $item) {
            Event::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'user_id' => null,
                    'category_id' => $category?->id,
                    'naslov' => $item['naslov'],
                    'opis_dug' => $item['opisDug'] ?? null,
                    'lokacija' => $item['lokacija'] ?? null,
                    'organizator' => $item['organizator'] ?? null,
                    'datum' => $item['datum'] ?? null,
                    'vrijeme' => $item['vrijeme'] ?? null,
                    'zavrseno' => $item['zavrseno'] ?? false,
                    'lat' => $item['lat'] ?? null,
                    'lng' => $item['lng'] ?? null,
                    ...$this->statusFields($i),
                ],
            );
        }
    }
}
