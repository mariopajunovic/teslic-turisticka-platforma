<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Med',
            'Rakija',
            'Borje',
            'Banja Vrućica',
            'Tradicija',
            'Porodično',
        ];

        foreach ($tags as $name) {
            Tag::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]);
        }
    }
}
