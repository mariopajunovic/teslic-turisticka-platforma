<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            CategorySeeder::class,
            BusinessSeeder::class,
            LocationSeeder::class,
            EventSeeder::class,
            AdSeeder::class,
            StorySeeder::class,
            NewsSeeder::class,
        ]);
    }
}
