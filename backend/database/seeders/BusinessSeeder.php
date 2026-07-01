<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\Concerns\SeedsMedia;
use Database\Seeders\Concerns\VariesStatus;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    use SeedsMedia;
    use VariesStatus;

    public function run(): void
    {
        $path = database_path('data/biznisi.json');

        if (! is_file($path)) {
            return;
        }

        $owner = User::where('email', 'biznis@komteldoo.com')->first();
        $items = json_decode(file_get_contents($path), true) ?? [];

        foreach ($items as $i => $item) {
            $icon = $item['kategorija']['icon'] ?? null;
            $category = $icon ? Category::where('key', $icon)->first() : null;

            $model = Business::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'user_id' => $owner?->id,
                    'category_id' => $category?->id,
                    'naslov' => $item['naslov'],
                    'opis' => $item['opis'] ?? null,
                    'opis_dug' => $item['opisDug'] ?? null,
                    'lokacija' => $item['lokacija'] ?? null,
                    'preporuceno' => $item['preporuceno'] ?? false,
                    'kontakt' => $item['kontakt'] ?? null,
                    'lat' => $item['lat'] ?? null,
                    'lng' => $item['lng'] ?? null,
                    ...$this->statusFields($i),
                ],
            );

            $this->attachSlika($model, $item['slika'] ?? null);
        }
    }
}
