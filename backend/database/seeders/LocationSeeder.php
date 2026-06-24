<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/lokaliteti.json');

        if (! is_file($path)) {
            return;
        }

        $items = json_decode(file_get_contents($path), true) ?? [];

        foreach ($items as $item) {
            $icon = $item['kategorija']['icon'] ?? null;
            $category = $icon ? Category::where('key', $icon)->first() : null;

            Location::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'user_id' => null,
                    'category_id' => $category?->id,
                    'naslov' => $item['naslov'],
                    'opis' => $item['opis'] ?? null,
                    'opis_dug' => $item['opisDug'] ?? null,
                    'lokacija' => $item['lokacija'] ?? null,
                    'preporuceno' => $item['preporuceno'] ?? false,
                    'kako_doci' => $item['kakoDoci'] ?? null,
                    'savjeti' => $item['savjeti'] ?? null,
                    'sezona' => $item['sezona'] ?? null,
                    'radno_vrijeme' => $item['radnoVrijeme'] ?? null,
                    'ulaznice' => $item['ulaznice'] ?? null,
                    'lat' => $item['lat'] ?? null,
                    'lng' => $item['lng'] ?? null,
                    'status' => ContentStatus::Objavljeno,
                    'published_at' => now(),
                ],
            );
        }
    }
}
