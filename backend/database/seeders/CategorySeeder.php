<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['key' => 'zanat', 'label' => 'Zanatski proizvodi', 'icon' => 'zanat', 'color' => '#E88828', 'type' => 'domace'],
            ['key' => 'hrana', 'label' => 'Domaća hrana i piće', 'icon' => 'hrana', 'color' => '#0E8275', 'type' => 'domace'],
            ['key' => 'usluge', 'label' => 'Usluge i servisi', 'icon' => 'usluge', 'color' => '#1C68B5', 'type' => 'domace'],

            ['key' => 'priroda', 'label' => 'Prirodne atrakcije', 'icon' => 'priroda', 'color' => '#1E7D3C', 'type' => 'turizam'],
            ['key' => 'kultura', 'label' => 'Kulturne manifestacije', 'icon' => 'kultura', 'color' => '#8C5810', 'type' => 'turizam'],
            ['key' => 'planine', 'label' => 'Planine, šume i sela', 'icon' => 'leaf', 'color' => '#5E8C1E', 'type' => 'turizam'],
            ['key' => 'smjestaj', 'label' => 'Gdje odsjesti', 'icon' => 'smjestaj', 'color' => '#0A645A', 'type' => 'turizam'],

            ['key' => 'domacini', 'label' => 'Domaćini pričaju', 'icon' => 'book-open', 'color' => '#8F5210', 'type' => 'price'],
            ['key' => 'ljudi', 'label' => 'Ljudi i biznisi', 'icon' => 'users', 'color' => '#1C68B5', 'type' => 'price'],
            ['key' => 'svakodnevica', 'label' => 'Naša svakodnevica', 'icon' => 'camera', 'color' => '#0E8275', 'type' => 'price'],
            ['key' => 'izdvojeno', 'label' => 'Izdvojeno', 'icon' => 'star', 'color' => '#E88828', 'type' => 'price'],

            ['key' => 'posao', 'label' => 'Posao', 'icon' => 'briefcase', 'color' => '#1C68B5', 'type' => 'oglasi'],
            ['key' => 'nekretnine', 'label' => 'Nekretnine', 'icon' => 'building-2', 'color' => '#8C5810', 'type' => 'oglasi'],
            ['key' => 'poziv', 'label' => 'Javni poziv', 'icon' => 'megaphone', 'color' => '#C62828', 'type' => 'oglasi'],

            ['key' => 'dogadjaj', 'label' => 'Događaji', 'icon' => 'dogadjaj', 'color' => '#C8D848', 'type' => 'dogadjaj'],
        ];

        foreach ($categories as $i => $data) {
            Category::updateOrCreate(['key' => $data['key']], [...$data, 'sort' => $i]);
        }
    }
}
