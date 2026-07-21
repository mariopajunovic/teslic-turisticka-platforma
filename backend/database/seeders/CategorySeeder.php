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
            ['key' => 'restorani', 'label' => 'Restorani', 'icon' => 'restorani', 'color' => '#C1440E', 'type' => 'domace'],
            ['key' => 'kafici-barovi', 'label' => 'Kafići i barovi', 'icon' => 'kafici', 'color' => '#6F4E37', 'type' => 'domace'],
            ['key' => 'smjestajni-kapaciteti', 'label' => 'Smještajni kapaciteti', 'icon' => 'smjestaj', 'color' => '#0A645A', 'type' => 'domace'],
            ['key' => 'seoska-domacinstva', 'label' => 'Seoska domaćinstva', 'icon' => 'seoska-domacinstva', 'color' => '#7A5C2E', 'type' => 'domace'],
            ['key' => 'zdravstvo', 'label' => 'Zdravstvo', 'icon' => 'zdravstvo', 'color' => '#1C88A8', 'type' => 'domace'],
            ['key' => 'ljepota-njega', 'label' => 'Ljepota i njega', 'icon' => 'ljepota', 'color' => '#C2557A', 'type' => 'domace'],
            ['key' => 'poljoprivreda', 'label' => 'Poljoprivreda i domaći proizvodi', 'icon' => 'poljoprivreda', 'color' => '#5E8C1E', 'type' => 'domace'],
            ['key' => 'zabava-rekreacija', 'label' => 'Zabava i rekreacija', 'icon' => 'zabava', 'color' => '#E0A215', 'type' => 'domace'],
            ['key' => 'trgovina', 'label' => 'Trgovina', 'icon' => 'trgovina', 'color' => '#1C68B5', 'type' => 'domace'],
            ['key' => 'prevoz', 'label' => 'Prevoz', 'icon' => 'prevoz', 'color' => '#4A5568', 'type' => 'domace'],
            ['key' => 'udruzenja-klubovi', 'label' => 'Udruženja i klubovi', 'icon' => 'users', 'color' => '#2E7D6B', 'type' => 'domace'],

            ['key' => 'priroda', 'label' => 'Prirodne atrakcije', 'icon' => 'priroda', 'color' => '#1E7D3C', 'type' => 'turizam'],
            ['key' => 'kultura', 'label' => 'Kulturne manifestacije', 'icon' => 'kultura', 'color' => '#8C5810', 'type' => 'turizam'],
            ['key' => 'planine', 'label' => 'Planine, šume i sela', 'icon' => 'leaf', 'color' => '#5E8C1E', 'type' => 'turizam'],
            ['key' => 'smjestaj', 'label' => 'Gdje odsjesti', 'icon' => 'smjestaj', 'color' => '#0A645A', 'type' => 'turizam'],
            ['key' => 'speleologija', 'label' => 'Speleologija', 'icon' => 'speleologija', 'color' => '#5A6B7A', 'type' => 'turizam'],
            ['key' => 'planinarenje', 'label' => 'Planinarenje', 'icon' => 'planinarenje', 'color' => '#3C7D3C', 'type' => 'turizam'],
            ['key' => 'vjerski-turizam', 'label' => 'Vjerski turizam', 'icon' => 'vjerski', 'color' => '#8C5810', 'type' => 'turizam'],
            ['key' => 'zdravstveni-turizam', 'label' => 'Zdravstveni turizam', 'icon' => 'zdravstveni', 'color' => '#0E8275', 'type' => 'turizam'],
            ['key' => 'izletista', 'label' => 'Izletišta', 'icon' => 'izletista', 'color' => '#5E8C1E', 'type' => 'turizam'],

            ['key' => 'domacini', 'label' => 'Domaćini pričaju', 'icon' => 'book-open', 'color' => '#8F5210', 'type' => 'price'],
            ['key' => 'ljudi', 'label' => 'Ljudi i biznisi', 'icon' => 'users', 'color' => '#1C68B5', 'type' => 'price'],
            ['key' => 'svakodnevica', 'label' => 'Naša svakodnevica', 'icon' => 'camera', 'color' => '#0E8275', 'type' => 'price'],
            ['key' => 'izdvojeno', 'label' => 'Izdvojeno', 'icon' => 'star', 'color' => '#E88828', 'type' => 'price'],

            ['key' => 'posao', 'label' => 'Posao', 'icon' => 'briefcase', 'color' => '#1C68B5', 'type' => 'oglasi'],
            ['key' => 'nekretnine', 'label' => 'Nekretnine', 'icon' => 'building-2', 'color' => '#8C5810', 'type' => 'oglasi'],
            ['key' => 'poziv', 'label' => 'Javni poziv', 'icon' => 'megaphone', 'color' => '#C62828', 'type' => 'oglasi'],

            ['key' => 'manifestacije', 'label' => 'Manifestacije', 'icon' => 'manifestacije', 'color' => '#B0C42C', 'type' => 'dogadjaj'],
            ['key' => 'dogadjaj', 'label' => 'Događaji', 'icon' => 'dogadjaj', 'color' => '#C8D848', 'type' => 'dogadjaj'],
        ];

        $hero = [
            'domace' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=1600&q=80',
            'turizam' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1600&q=80',
            'price' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1600&q=80',
            'oglasi' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1600&q=80',
            'dogadjaj' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1600&q=80',
        ];

        foreach ($categories as $i => $data) {
            $label = Prevodi::tr($data['label']);

            $kategorija = Category::firstOrNew(['key' => $data['key']]);
            $kategorija->fill([
                'icon' => $data['icon'],
                'color' => $data['color'],
                'type' => $data['type'],
                'sort' => $i,
                'hero_image' => $hero[$data['type']] ?? null,
            ]);
            $kategorija->setTranslations('label', $label);
            $kategorija->setTranslations('opis', $this->opis($label));
            $kategorija->setTranslations('meta_title', [
                'sr' => $label['sr'].' - Teslić',
                'en' => $label['en'].' - Teslić',
                'de' => $label['de'].' - Teslić',
            ]);
            $kategorija->setTranslations('meta_description', [
                'sr' => 'Sadržaj kategorije '.$label['sr'].' na platformi Turističke organizacije Teslić.',
                'en' => 'Content of the '.$label['en'].' category on the platform of the Tourism Organization of Teslić.',
                'de' => 'Inhalte der Kategorie '.$label['de'].' auf der Plattform der Tourismusorganisation Teslić.',
            ]);
            $kategorija->save();
        }
    }

    protected function opis(array $l): array
    {
        return [
            'sr' => 'Pregledajte sadržaj u kategoriji „'.$l['sr'].'" iz Teslića i okoline - odabran i provjeren na jednom mjestu.',
            'en' => 'Browse the "'.$l['en'].'" category from Teslić and the surrounding area - curated and verified in one place.',
            'de' => 'Entdecken Sie die Kategorie „'.$l['de'].'" aus Teslić und Umgebung - ausgewählt und geprüft an einem Ort.',
        ];
    }
}
