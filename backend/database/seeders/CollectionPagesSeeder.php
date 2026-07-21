<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CollectionPagesSeeder extends Seeder
{
    protected const KOLEKCIJE = [
        'business' => [
            'slug' => ['sr' => 'domace-je-najbolje', 'en' => 'local-products', 'de' => 'lokale-produkte'],
            'title' => 'Domaće je najbolje',
            'kicker' => ['sr' => 'Domaće je najbolje', 'en' => 'Local is best', 'de' => 'Lokal ist am besten'],
            'hero' => ['sr' => 'Domaća ponuda Teslića', 'en' => 'Local offerings of Teslić', 'de' => 'Heimisches Angebot von Teslić'],
            'podnaslov' => [
                'sr' => 'Med, rakija, sirevi, zanati i usluge - upoznajte ljude i proizvode koji čine Teslić posebnim.',
                'en' => 'Honey, rakia, cheeses, crafts and services - meet the people and products that make Teslić special.',
                'de' => 'Honig, Rakija, Käse, Handwerk und Dienstleistungen - lernen Sie die Menschen und Produkte kennen, die Teslić besonders machen.',
            ],
            'slika' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=1600&q=80',
        ],
        'location' => [
            'slug' => ['sr' => 'turizam', 'en' => 'tourism', 'de' => 'tourismus'],
            'title' => 'Turizam',
            'kicker' => ['sr' => 'Turizam u Tesliću', 'en' => 'Tourism in Teslić', 'de' => 'Tourismus in Teslić'],
            'hero' => ['sr' => 'Priroda i baština Teslića', 'en' => 'Nature and heritage of Teslić', 'de' => 'Natur und Erbe von Teslić'],
            'podnaslov' => [
                'sr' => 'Planine, rijeke, banje i kulturno nasljeđe - otkrijte lokalitete koji čine Teslić destinacijom.',
                'en' => 'Mountains, rivers, spas and cultural heritage - discover the sites that make Teslić a destination.',
                'de' => 'Berge, Flüsse, Thermalbäder und kulturelles Erbe - entdecken Sie die Orte, die Teslić zu einem Reiseziel machen.',
            ],
            'slika' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1600&q=80',
        ],
        'event' => [
            'slug' => ['sr' => 'dogadjaji', 'en' => 'events', 'de' => 'veranstaltungen'],
            'title' => 'Manifestacije i događaji',
            'kicker' => ['sr' => 'Manifestacije i događaji', 'en' => 'Festivals and events', 'de' => 'Festivals und Veranstaltungen'],
            'hero' => ['sr' => 'Šta se dešava u Tesliću', 'en' => "What's happening in Teslić", 'de' => 'Was in Teslić los ist'],
            'podnaslov' => [
                'sr' => 'Festivali, sajmovi, izleti i kulturna dešavanja - pratite kalendar događaja teslićkog kraja.',
                'en' => 'Festivals, fairs, outings and cultural happenings - follow the events calendar of the Teslić area.',
                'de' => 'Festivals, Messen, Ausflüge und kulturelle Ereignisse - verfolgen Sie den Veranstaltungskalender der Region Teslić.',
            ],
            'slika' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1600&q=80',
        ],
        'ad' => [
            'slug' => ['sr' => 'oglasi', 'en' => 'classifieds', 'de' => 'kleinanzeigen'],
            'title' => 'Oglasi',
            'kicker' => ['sr' => 'Poslovne prilike', 'en' => 'Business opportunities', 'de' => 'Geschäftsmöglichkeiten'],
            'hero' => ['sr' => 'Oglasi i prilike u Tesliću', 'en' => 'Ads and opportunities in Teslić', 'de' => 'Anzeigen und Chancen in Teslić'],
            'podnaslov' => [
                'sr' => 'Poslovi, konkursi, otkup i saradnje - prilike koje povezuju ljude i biznise teslićkog kraja.',
                'en' => 'Jobs, competitions, purchases and collaborations - opportunities that connect people and businesses of the Teslić area.',
                'de' => 'Jobs, Ausschreibungen, Ankäufe und Kooperationen - Möglichkeiten, die Menschen und Unternehmen der Region Teslić verbinden.',
            ],
            'slika' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1600&q=80',
        ],
        'story' => [
            'slug' => ['sr' => 'price', 'en' => 'stories', 'de' => 'geschichten'],
            'title' => 'Priče',
            'kicker' => ['sr' => 'Priče iz Teslića', 'en' => 'Stories from Teslić', 'de' => 'Geschichten aus Teslić'],
            'hero' => ['sr' => 'Ljudi, mjesta i običaji Teslića', 'en' => 'People, places and customs of Teslić', 'de' => 'Menschen, Orte und Bräuche von Teslić'],
            'podnaslov' => [
                'sr' => 'Autentične priče domaćina, zanatlija i autora koji svojim radom i životom oblikuju kraj.',
                'en' => 'Authentic stories of hosts, artisans and authors who shape the region through their work and life.',
                'de' => 'Authentische Geschichten von Gastgebern, Handwerkern und Autoren, die die Region durch ihre Arbeit und ihr Leben prägen.',
            ],
            'slika' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1600&q=80',
        ],
        'news' => [
            'slug' => ['sr' => 'vijesti', 'en' => 'news', 'de' => 'nachrichten'],
            'title' => ['sr' => 'Vijesti', 'en' => 'News', 'de' => 'Nachrichten'],
            'kicker' => ['sr' => 'Vijesti', 'en' => 'News', 'de' => 'Nachrichten'],
            'hero' => ['sr' => 'Novosti iz Teslića', 'en' => 'News from Teslić', 'de' => 'Neuigkeiten aus Teslić'],
            'podnaslov' => [
                'sr' => 'Servisna obavještenja, izvještaji i aktuelnosti Turističke organizacije grada Teslića.',
                'en' => 'Service announcements, reports and news from the Tourism Organization of the City of Teslić.',
                'de' => 'Servicehinweise, Berichte und Aktuelles der Tourismusorganisation der Stadt Teslić.',
            ],
            'slika' => 'https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=1600&q=80',
        ],
        'procurement' => [
            'slug' => ['sr' => 'javne-nabavke', 'en' => 'procurement', 'de' => 'ausschreibungen'],
            'title' => ['sr' => 'Javne nabavke', 'en' => 'Public procurement', 'de' => 'Ausschreibungen'],
            'kicker' => ['sr' => 'Javne nabavke', 'en' => 'Public procurement', 'de' => 'Ausschreibungen'],
            'hero' => ['sr' => 'Javne nabavke', 'en' => 'Public procurement', 'de' => 'Ausschreibungen'],
            'podnaslov' => [
                'sr' => 'Objave javnih nabavki po godinama, sa pratećom dokumentacijom.',
                'en' => 'Public procurement notices by year, with accompanying documentation.',
                'de' => 'Öffentliche Ausschreibungen nach Jahren, mit begleitender Dokumentation.',
            ],
            'slika' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1600&q=80',
        ],
    ];

    public function run(): void
    {
        $sort = (int) Page::max('sort');

        foreach (self::KOLEKCIJE as $tip => $def) {
            $slug = is_array($def['slug']) ? $def['slug'] : ['sr' => $def['slug']];
            $title = is_array($def['title']) ? $def['title'] : Prevodi::tr($def['title']);

            $stranica = Page::where('slug->sr', $slug['sr'])->first() ?? new Page();

            $stranica->fill([
                'published' => true,
                'is_system' => true,
                'resource_type' => $tip,
                'category_id' => null,
                'parent_id' => null,
            ]);

            $stranica->setTranslations('title', $title);
            $stranica->setTranslations('meta_title', $def['hero']);
            $stranica->setTranslations('meta_description', $def['podnaslov']);

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

        $this->istaknute();
    }

    protected const ISTAKNUTE = [
        [
            'slug' => 'ztc-banja-vrucica',
            'title' => 'ZTC Banja Vrućica',
            'kicker' => ['sr' => 'Zdravstveno-turistički centar', 'en' => 'Health and tourism center', 'de' => 'Gesundheits- und Tourismuszentrum'],
            'hero' => 'ZTC Banja Vrućica',
            'podnaslov' => [
                'sr' => 'Najveći banjski i zdravstveno-turistički centar u regiji, sa termalnim izvorima, wellness i medicinskim programima.',
                'en' => 'The largest spa and health tourism center in the region, with thermal springs, wellness and medical programs.',
                'de' => 'Das größte Kur- und Gesundheitstourismuszentrum der Region, mit Thermalquellen, Wellness- und medizinischen Programmen.',
            ],
            'slika' => 'https://images.unsplash.com/photo-1610641818989-c2051b5e2cfd?auto=format&fit=crop&w=1600&q=80',
        ],
        [
            'slug' => 'hotel-hajducke-vode',
            'title' => 'Hotel Hajdučke vode',
            'kicker' => ['sr' => 'Planinski hotel', 'en' => 'Mountain hotel', 'de' => 'Berghotel'],
            'hero' => 'Hotel Hajdučke vode',
            'podnaslov' => [
                'sr' => 'Planinski hotel na Borju, okružen šumom i prirodom, idealan za odmor, izlete i planinarenje.',
                'en' => 'A mountain hotel on Borje, surrounded by forest and nature, ideal for relaxation, outings and hiking.',
                'de' => 'Ein Berghotel auf dem Borje, umgeben von Wald und Natur, ideal für Erholung, Ausflüge und Wandern.',
            ],
            'slika' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1600&q=80',
        ],
    ];

    protected function istaknute(): void
    {
        $roditelj = Page::where('slug->sr', 'turizam')->whereNull('parent_id')->first();

        if (! $roditelj) {
            return;
        }

        foreach (self::ISTAKNUTE as $i => $def) {
            $stranica = Page::where('parent_id', $roditelj->id)->where('slug->sr', $def['slug'])->first() ?? new Page();

            $stranica->fill([
                'parent_id' => $roditelj->id,
                'published' => true,
                'is_system' => false,
                'resource_type' => null,
                'category_id' => null,
            ]);

            $stranica->setTranslations('title', Prevodi::tr($def['title']));
            $stranica->setTranslations('meta_title', Prevodi::tr($def['hero']));
            $stranica->setTranslations('meta_description', $def['podnaslov']);

            $stranica->slug = ['sr' => $def['slug'], 'en' => $def['slug'], 'de' => $def['slug']];
            $stranica->sort = $i;
            $stranica->content = [
                ['type' => 'hero', 'data' => [
                    'variant' => 'slika-pozadina',
                    'kicker' => $def['kicker'],
                    'title' => $def['hero'],
                    'subtitle' => $def['podnaslov'],
                    'image' => $def['slika'],
                ]],
                ['type' => 'rich_text', 'data' => ['sadrzaj' => [
                    'sr' => '<p>'.$def['podnaslov']['sr'].'</p>',
                    'en' => '<p>'.$def['podnaslov']['en'].'</p>',
                    'de' => '<p>'.$def['podnaslov']['de'].'</p>',
                ]]],
            ];
            $stranica->save();
        }
    }

    protected function djeca(Page $roditelj, string $tip, array $def): void
    {
        $tipKategorije = config('resources.types.'.$tip.'.category_type');

        if (! $tipKategorije) {
            return;
        }

        $kicker = is_array($def['title']) ? $def['title'] : Prevodi::tr($def['title']);
        $kategorije = Category::where('type', $tipKategorije)->orderBy('sort')->get();

        foreach ($kategorije as $i => $kategorija) {
            $slug = $kategorija->slugFor('sr') ?: $kategorija->key;
            $label = $this->popuni($kategorija->getTranslations('label'), $kategorija->key);
            $opis = $this->popuni($kategorija->getTranslations('opis'), '');

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

            $dijete->setTranslations('title', $label);
            $dijete->setTranslations('meta_title', $label);
            $dijete->setTranslations('meta_description', $opis);

            $dijete->slug = [
                'sr' => $slug,
                'en' => Str::slug($label['en']) ?: $slug,
                'de' => Str::slug($label['de']) ?: $slug,
            ];
            $dijete->sort = $i;
            $dijete->content = [
                ['type' => 'hero', 'data' => [
                    'variant' => 'split',
                    'kicker' => $kicker,
                    'title' => $label,
                    'subtitle' => $opis,
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

    protected function popuni(array $mapa, string $fallback): array
    {
        $sr = $mapa['sr'] ?? $fallback;

        return [
            'sr' => $sr,
            'en' => $mapa['en'] ?? $sr,
            'de' => $mapa['de'] ?? $sr,
        ];
    }
}
