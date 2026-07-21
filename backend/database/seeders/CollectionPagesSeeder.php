<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use Illuminate\Database\Seeder;

class CollectionPagesSeeder extends Seeder
{
    protected const KOLEKCIJE = [
        'business' => [
            'slug' => 'domace-je-najbolje',
            'title' => 'Domaće je najbolje',
            'kicker' => 'Domaće je najbolje',
            'hero' => 'Domaća ponuda Teslića',
            'podnaslov' => 'Med, rakija, sirevi, zanati i usluge - upoznajte ljude i proizvode koji čine Teslić posebnim.',
            'slika' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=1600&q=80',
        ],
        'location' => [
            'slug' => 'turizam',
            'title' => 'Turizam',
            'kicker' => 'Turizam u Tesliću',
            'hero' => 'Priroda i baština Teslića',
            'podnaslov' => 'Planine, rijeke, banje i kulturno nasljeđe - otkrijte lokalitete koji čine Teslić destinacijom.',
            'slika' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1600&q=80',
        ],
        'event' => [
            'slug' => 'dogadjaji',
            'title' => 'Događaji',
            'kicker' => 'Događaji',
            'hero' => 'Šta se dešava u Tesliću',
            'podnaslov' => 'Festivali, sajmovi, izleti i kulturna dešavanja - pratite kalendar događaja teslićkog kraja.',
            'slika' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1600&q=80',
        ],
        'ad' => [
            'slug' => 'oglasi',
            'title' => 'Oglasi',
            'kicker' => 'Poslovne prilike',
            'hero' => 'Oglasi i prilike u Tesliću',
            'podnaslov' => 'Poslovi, konkursi, otkup i saradnje - prilike koje povezuju ljude i biznise teslićkog kraja.',
            'slika' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1600&q=80',
        ],
        'story' => [
            'slug' => 'price',
            'title' => 'Priče',
            'kicker' => 'Priče iz Teslića',
            'hero' => 'Ljudi, mjesta i običaji Teslića',
            'podnaslov' => 'Autentične priče domaćina, zanatlija i autora koji svojim radom i životom oblikuju kraj.',
            'slika' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1600&q=80',
        ],
        'news' => [
            'slug' => ['sr' => 'vijesti', 'en' => 'news', 'de' => 'nachrichten'],
            'title' => ['sr' => 'Vijesti', 'en' => 'News', 'de' => 'Nachrichten'],
            'kicker' => 'Vijesti',
            'hero' => 'Novosti iz Teslića',
            'podnaslov' => 'Servisna obavještenja, izvještaji i aktuelnosti Turističke organizacije grada Teslića.',
            'slika' => 'https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=1600&q=80',
        ],
        'procurement' => [
            'slug' => ['sr' => 'javne-nabavke', 'en' => 'procurement', 'de' => 'ausschreibungen'],
            'title' => ['sr' => 'Javne nabavke', 'en' => 'Public procurement', 'de' => 'Ausschreibungen'],
            'kicker' => 'Javne nabavke',
            'hero' => 'Javne nabavke',
            'podnaslov' => 'Objave javnih nabavki po godinama, sa pratećom dokumentacijom.',
            'slika' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1600&q=80',
        ],
    ];

    public function run(): void
    {
        $sort = (int) Page::max('sort');

        foreach (self::KOLEKCIJE as $tip => $def) {
            $slug = is_array($def['slug']) ? $def['slug'] : ['sr' => $def['slug']];
            $title = is_array($def['title']) ? $def['title'] : ['sr' => $def['title']];

            $stranica = Page::where('slug->sr', $slug['sr'])->first() ?? new Page();

            $stranica->fill([
                'published' => true,
                'is_system' => true,
                'resource_type' => $tip,
                'category_id' => null,
                'parent_id' => null,
            ]);

            $stranica->setTranslations('title', $title);
            $stranica->setTranslations('meta_title', ['sr' => $def['hero']]);
            $stranica->setTranslations('meta_description', ['sr' => $def['podnaslov']]);

            $stranica->slug = $slug;
            $stranica->sort = $stranica->sort ?: ++$sort;
            $stranica->content = [
                ['type' => 'hero', 'data' => [
                    'variant' => 'split',
                    'kicker' => $def['kicker'],
                    'title' => $def['hero'],
                    'subtitle' => $def['podnaslov'],
                    'image' => $def['slika'],
                ]],
                ['type' => 'resource_list', 'data' => [
                    'perPage' => 12,
                    'cols' => 4,
                    'filteri' => true,
                    'pretraga' => true,
                ]],
            ];
            $stranica->save();

            $this->djeca($stranica, $tip, $def);
        }
    }

    protected function djeca(Page $roditelj, string $tip, array $def): void
    {
        $tipKategorije = config('resources.types.'.$tip.'.category_type');

        if (! $tipKategorije) {
            return;
        }

        $kategorije = Category::where('type', $tipKategorije)->orderBy('sort')->get();

        foreach ($kategorije as $i => $kategorija) {
            $slug = $kategorija->slugFor('sr') ?: $kategorija->key;
            $naziv = $kategorija->getTranslations('label')['sr'] ?? $kategorija->key;

            $dijete = Page::where('parent_id', $roditelj->id)->where('category_id', $kategorija->id)->first()
                ?? Page::where('parent_id', $roditelj->id)->where('slug->sr', $slug)->first()
                ?? new Page();

            $dijete->fill([
                'parent_id' => $roditelj->id,
                'published' => true,
                'is_system' => false,
                'resource_type' => $tip,
                'category_id' => $kategorija->id,
            ]);

            $dijete->setTranslations('title', ['sr' => $naziv]);
            $dijete->setTranslations('meta_title', ['sr' => $naziv.' - Teslić']);
            $dijete->setTranslations('meta_description', ['sr' => $kategorija->getTranslations('opis')['sr'] ?? '']);

            $dijete->slug = ['sr' => $slug];
            $dijete->sort = $i;
            $dijete->content = [
                ['type' => 'hero', 'data' => [
                    'variant' => 'split',
                    'kicker' => $def['title'],
                    'title' => $naziv,
                    'subtitle' => $kategorija->getTranslations('opis')['sr'] ?? '',
                    'image' => $kategorija->hero_image ?: $def['slika'],
                ]],
                ['type' => 'resource_list', 'data' => [
                    'perPage' => 12,
                    'cols' => 4,
                    'filteri' => false,
                    'pretraga' => false,
                ]],
            ];
            $dijete->save();
        }
    }
}
