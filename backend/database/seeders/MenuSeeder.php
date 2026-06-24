<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $this->menu('main', 'Glavna navigacija', [
            ['Domaće je najbolje', '/domace-je-najbolje', [
                ['Zanatski proizvodi', '/domace-je-najbolje?kategorija=zanat'],
                ['Domaća hrana i piće', '/domace-je-najbolje?kategorija=hrana'],
                ['Usluge i servisi', '/domace-je-najbolje?kategorija=usluge'],
            ]],
            ['Turizam', '/turizam', [
                ['Prirodne atrakcije', '/turizam?kategorija=priroda'],
                ['Kulturne manifestacije', '/turizam?kategorija=kultura'],
                ['Planine, šume i sela', '/turizam?kategorija=planine'],
                ['Gdje odsjesti', '/turizam?kategorija=smjestaj'],
            ]],
            ['Događaji', '/dogadjaji'],
            ['Oglasi', '/oglasi'],
            ['Mapa', '/mapa'],
            ['Priče', '/price', [
                ['Domaćini pričaju', '/price?kategorija=domacini'],
                ['Ljudi i biznisi', '/price?kategorija=ljudi'],
                ['Naša svakodnevica', '/price?kategorija=svakodnevica'],
            ]],
        ]);

        $this->menu('secondary', 'Sekundarna (util traka)', [
            ['O projektu', '/o-projektu'],
            ['Kontakt', '/kontakt'],
        ]);

        $this->menu('footer_brzi', 'Footer — Brzi linkovi', [
            ['Početna', '/'],
            ['O projektu', '/o-projektu'],
            ['Događaji', '/dogadjaji'],
            ['Pridruži se', '/pridruzi-se'],
        ]);

        $this->menu('footer_istrazi', 'Footer — Istraži', [
            ['Domaće je najbolje', '/domace-je-najbolje'],
            ['Turizam', '/turizam'],
            ['Mapa ponude', '/mapa'],
            ['Priče', '/price'],
        ]);

        $this->menu('footer_pravno', 'Footer — Pravno', [
            ['Politika privatnosti', '/politika-privatnosti'],
            ['Politika kolačića', '/politika-kolacica'],
            ['Uslovi korištenja', '/uslovi-koristenja'],
        ]);
    }

    protected function menu(string $key, string $name, array $items): void
    {
        $menu = Menu::updateOrCreate(['key' => $key], ['name' => $name]);
        $menu->items()->delete();

        foreach ($items as $i => $item) {
            [$label, $url] = $item;
            $children = $item[2] ?? [];

            $parent = $menu->items()->create([
                'label' => $label,
                'url' => $url,
                'sort' => $i,
            ]);

            foreach ($children as $j => $child) {
                $menu->items()->create([
                    'parent_id' => $parent->id,
                    'label' => $child[0],
                    'url' => $child[1],
                    'sort' => $j,
                ]);
            }
        }
    }
}
