<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $this->menu('main', 'Glavna navigacija', [
            ['Domaće je najbolje', '/domace-je-najbolje', [
                ['Zanatski proizvodi', '/domace-je-najbolje/kategorija/zanat'],
                ['Domaća hrana i piće', '/domace-je-najbolje/kategorija/hrana'],
                ['Usluge i servisi', '/domace-je-najbolje/kategorija/usluge'],
            ]],
            ['Turizam', '/turizam', [
                ['Prirodne atrakcije', '/turizam/kategorija/priroda'],
                ['Kulturne manifestacije', '/turizam/kategorija/kultura'],
                ['Planine, šume i sela', '/turizam/kategorija/planine'],
                ['Gdje odsjesti', '/turizam/kategorija/smjestaj'],
            ]],
            ['Događaji', '/dogadjaji'],
            ['Oglasi', '/oglasi'],
            ['Mapa', '/mapa'],
            ['Priče', '/price', [
                ['Domaćini pričaju', '/price/kategorija/domacini'],
                ['Ljudi i biznisi', '/price/kategorija/ljudi'],
                ['Naša svakodnevica', '/price/kategorija/svakodnevica'],
            ]],
        ]);

        $this->menu('secondary', 'Sekundarna (util traka)', [
            ['O projektu', '/o-projektu'],
            ['Kontakt', '/kontakt'],
        ]);

        $this->menu('footer_brzi', 'Footer - Brzi linkovi', [
            ['Početna', '/'],
            ['O projektu', '/o-projektu'],
            ['Događaji', '/dogadjaji'],
            ['Pridruži se', '/pridruzi-se'],
        ]);

        $this->menu('footer_istrazi', 'Footer - Istraži', [
            ['Domaće je najbolje', '/domace-je-najbolje'],
            ['Turizam', '/turizam'],
            ['Mapa ponude', '/mapa'],
            ['Priče', '/price'],
        ]);

        $this->menu('footer_pravno', 'Footer - Pravno', [
            ['Politika privatnosti', '/politika-privatnosti'],
            ['Politika kolačića', '/politika-kolacica'],
            ['Uslovi korištenja', '/uslovi-koristenja'],
        ]);
    }

    protected function cilj(string $url): array
    {
        if (str_starts_with($url, 'http')) {
            return [MenuItem::CILJ_VANJSKI, null, $url];
        }

        $segmenti = array_values(array_filter(explode('/', trim($url, '/'))));

        if (! $segmenti) {
            $home = Page::where('slug->sr', 'pocetna')->first();

            return $home ? [MenuItem::CILJ_STRANICA, $home->id, null] : [MenuItem::CILJ_VANJSKI, null, $url];
        }

        if (count($segmenti) === 3 && $segmenti[1] === 'kategorija') {
            $kategorija = Category::where('key', $segmenti[2])->first();

            if ($kategorija) {
                return [MenuItem::CILJ_KATEGORIJA, $kategorija->id, null];
            }
        }

        $roditelj = Page::where('slug->sr', $segmenti[0])->whereNull('parent_id')->first();

        if ($roditelj && count($segmenti) === 1) {
            return [MenuItem::CILJ_STRANICA, $roditelj->id, null];
        }

        if ($roditelj && count($segmenti) === 2) {
            $dijete = Page::where('parent_id', $roditelj->id)->where('slug->sr', $segmenti[1])->first();

            if ($dijete) {
                return $dijete->category_id
                    ? [MenuItem::CILJ_KATEGORIJA, $dijete->category_id, null]
                    : [MenuItem::CILJ_STRANICA, $dijete->id, null];
            }
        }

        return [MenuItem::CILJ_VANJSKI, null, $url];
    }

    protected function menu(string $key, string $name, array $items): void
    {
        $menu = Menu::updateOrCreate(['key' => $key], ['name' => $name]);
        $menu->items()->whereNotNull('parent_id')->delete();
        $menu->items()->delete();

        foreach ($items as $i => $item) {
            [$label, $url] = $item;
            $children = $item[2] ?? [];

            [$tip, $id, $vanjski] = $this->cilj($url);

            $parent = $menu->items()->make([
                'target_type' => $tip,
                'target_id' => $id,
                'url' => $vanjski,
                'sort' => $i,
            ]);
            $parent->setTranslations('label', ['sr' => $label]);
            $parent->save();

            foreach ($children as $j => $child) {
                [$ctip, $cid, $cvanjski] = $this->cilj($child[1]);

                $dijete = $menu->items()->make([
                    'parent_id' => $parent->id,
                    'target_type' => $ctip,
                    'target_id' => $cid,
                    'url' => $cvanjski,
                    'sort' => $j,
                ]);
                $dijete->setTranslations('label', ['sr' => $child[0]]);
                $dijete->save();
            }
        }
    }
}
