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
            RolePermissionSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            PageSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            BusinessSeeder::class,
            LocationSeeder::class,
            EventSeeder::class,
            AdSeeder::class,
            StorySeeder::class,
            NewsSeeder::class,
            ContentLinkSeeder::class,
        ]);
    }
}
