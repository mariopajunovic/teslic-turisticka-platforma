<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['key' => 'zanat', 'label' => 'Zanatski proizvodi', 'icon' => 'zanat', 'type' => 'domace'],
            ['key' => 'hrana', 'label' => 'Hrana i piće', 'icon' => 'hrana', 'type' => 'domace'],
            ['key' => 'usluge', 'label' => 'Usluge i servisi', 'icon' => 'usluge', 'type' => 'domace'],
            ['key' => 'priroda', 'label' => 'Prirodne atrakcije', 'icon' => 'priroda', 'type' => 'turizam'],
            ['key' => 'kultura', 'label' => 'Kultura', 'icon' => 'kultura', 'type' => 'turizam'],
            ['key' => 'smjestaj', 'label' => 'Smještaj', 'icon' => 'smjestaj', 'type' => 'turizam'],
            ['key' => 'dogadjaj', 'label' => 'Događaji', 'icon' => 'dogadjaj', 'type' => 'dogadjaj'],
        ];

        foreach ($categories as $i => $data) {
            Category::updateOrCreate(
                ['key' => $data['key']],
                [...$data, 'sort' => $i],
            );
        }
    }
}
