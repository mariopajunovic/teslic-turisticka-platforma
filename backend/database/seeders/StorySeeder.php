<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Category;
use App\Models\Story;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/price.json');

        if (! is_file($path)) {
            return;
        }

        $owner = User::where('email', 'autor@komteldoo.com')->first();
        $items = json_decode(file_get_contents($path), true) ?? [];

        foreach ($items as $item) {
            $kategorija = $item['kategorija'] ?? [];
            $key = $kategorija['icon'] ?? Str::slug($kategorija['label'] ?? '');

            $category = Category::firstOrCreate(
                ['key' => $key],
                [
                    'label' => $kategorija['label'] ?? $key,
                    'icon' => $kategorija['icon'] ?? null,
                    'type' => 'price',
                ],
            );

            $datumRaw = $item['datum'] ?? null;
            $datum = null;
            if ($datumRaw) {
                try {
                    $datum = Carbon::createFromFormat('d.m.Y.', rtrim($datumRaw, ' '));
                } catch (\Exception) {
                    $datum = null;
                }
            }

            Story::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'user_id' => $owner?->id,
                    'category_id' => $category->id,
                    'naslov' => $item['naslov'],
                    'izvod' => $item['izvod'] ?? null,
                    'sadrzaj' => $item['sadrzaj'] ?? null,
                    'autor' => $item['autor'] ?? null,
                    'autor_bio' => $item['autorBio'] ?? null,
                    'datum' => $datum,
                    'featured' => $item['featured'] ?? false,
                    'status' => ContentStatus::Objavljeno,
                    'published_at' => now(),
                ],
            );
        }
    }
}
