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
            ['key' => 'hrana', 'label' => 'Domaća hrana i piće', 'icon' => 'hrana', 'type' => 'domace'],
            ['key' => 'usluge', 'label' => 'Usluge i servisi', 'icon' => 'usluge', 'type' => 'domace'],

            ['key' => 'priroda', 'label' => 'Prirodne atrakcije', 'icon' => 'priroda', 'type' => 'turizam'],
            ['key' => 'kultura', 'label' => 'Kulturne manifestacije', 'icon' => 'kultura', 'type' => 'turizam'],
            ['key' => 'planine', 'label' => 'Planine, šume i sela', 'icon' => 'leaf', 'type' => 'turizam'],
            ['key' => 'smjestaj', 'label' => 'Gdje odsjesti', 'icon' => 'smjestaj', 'type' => 'turizam'],

            ['key' => 'domacini', 'label' => 'Domaćini pričaju', 'icon' => 'book-open', 'type' => 'price'],
            ['key' => 'ljudi', 'label' => 'Ljudi i biznisi', 'icon' => 'users', 'type' => 'price'],
            ['key' => 'svakodnevica', 'label' => 'Naša svakodnevica', 'icon' => 'camera', 'type' => 'price'],
            ['key' => 'izdvojeno', 'label' => 'Izdvojeno', 'icon' => 'star', 'type' => 'price'],

            ['key' => 'posao', 'label' => 'Posao', 'icon' => 'briefcase', 'type' => 'oglasi'],
            ['key' => 'nekretnine', 'label' => 'Nekretnine', 'icon' => 'building-2', 'type' => 'oglasi'],
            ['key' => 'poziv', 'label' => 'Javni poziv', 'icon' => 'megaphone', 'type' => 'oglasi'],

            ['key' => 'dogadjaj', 'label' => 'Događaji', 'icon' => 'dogadjaj', 'type' => 'dogadjaj'],
        ];

        foreach ($categories as $i => $data) {
            Category::updateOrCreate(['key' => $data['key']], [...$data, 'sort' => $i]);
        }
    }
}
