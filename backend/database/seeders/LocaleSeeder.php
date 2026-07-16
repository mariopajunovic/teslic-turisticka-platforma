<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Seeder;

class LocaleSeeder extends Seeder
{
    public function run(): void
    {
        $system = [
            ['code' => 'sr', 'name' => 'Srpski', 'sort_order' => 1],
            ['code' => 'en', 'name' => 'English', 'sort_order' => 2],
            ['code' => 'de', 'name' => 'Deutsch', 'sort_order' => 3],
        ];

        foreach ($system as $l) {
            Locale::updateOrCreate(
                ['code' => $l['code']],
                [
                    'name' => $l['name'],
                    'is_system' => true,
                    'is_active' => true,
                    'sort_order' => $l['sort_order'],
                ]
            );
        }
    }
}
