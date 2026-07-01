<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use Database\Seeders\Concerns\SeedsMedia;
use Database\Seeders\Concerns\VariesStatus;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    use SeedsMedia;
    use VariesStatus;

    protected const LABEL_TO_KEY = [
        'Prirodne atrakcije' => 'priroda',
        'Kultura' => 'kultura',
        'Kulturne manifestacije' => 'kultura',
        'Planine, šume i sela' => 'planine',
        'Gdje odsjesti' => 'smjestaj',
    ];

    public function run(): void
    {
        $path = database_path('data/lokaliteti.json');

        if (! is_file($path)) {
            return;
        }

        $items = json_decode(file_get_contents($path), true) ?? [];

        foreach ($items as $i => $item) {
            $label = $item['kategorija']['label'] ?? null;
            $key = self::LABEL_TO_KEY[$label] ?? null;
            $category = $key ? Category::where('key', $key)->first() : null;

            $model = Location::updateOrCreate(
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
                    ...$this->statusFields($i),
                ],
            );

            $this->attachSlika($model, $item['slika'] ?? null);
        }
    }
}
