<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\StoryResource;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\Page;
use App\Models\Story;
use App\Settings\SiteSettings;
use App\Support\MapPoints;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;
use App\Support\ResourceUrls;

class PageController extends Controller
{
    public function home(): Response
    {
        $page = Page::published()->where('slug->sr', 'pocetna')->first();

        if (! $page) {
            return Inertia::render('Home');
        }

        return $this->renderPage($page);
    }

    public function show(string $slug): Response
    {
        $query = Page::whereSlug($slug)->whereNull('parent_id');

        if (! $this->previewing()) {
            $query->published();
        }

        return $this->renderPage($query->firstOrFail());
    }

    public function child(string $parent, string $slug): Response
    {
        $roditelj = Page::whereSlug($parent)->whereNull('parent_id')->firstOrFail();

        $query = Page::whereSlug($slug)->where('parent_id', $roditelj->id);

        if (! $this->previewing()) {
            $query->published();
        }

        return $this->renderPage($query->firstOrFail());
    }

    public function about(): Response
    {
        $biznis = Business::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $dogadjaj = Event::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $prica = Story::objavljeno()->with(['category', 'media'])->latest('published_at')->first();

        return Inertia::render('About', [
            'related' => [
                'biznis' => $biznis ? (new BusinessResource($biznis))->resolve() : null,
                'dogadjaj' => $dogadjaj ? (new EventResource($dogadjaj))->resolve() : null,
                'prica' => $prica ? (new StoryResource($prica))->resolve() : null,
            ],
            'seo' => Seo::make(
                'O projektu',
                'Platforma koja na jednom mjestu okuplja domaću ponudu, turizam, događaje i priče Teslića.',
                url('/o-projektu'),
            ),
        ]);
    }

    protected function previewing(): bool
    {
        return request()->boolean('preview') && auth('admin')->check();
    }

    protected function povezaniSadrzaj(): array
    {
        $biznis = Business::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $lokalitet = Location::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $dogadjaj = Event::objavljeno()->with(['category', 'media'])->latest('published_at')->first();

        return [
            'biznis' => $biznis ? (new BusinessResource($biznis))->resolve() : null,
            'lokalitet' => $lokalitet ? (new LocationResource($lokalitet))->resolve() : null,
            'dogadjaj' => $dogadjaj ? (new EventResource($dogadjaj))->resolve() : null,
        ];
    }

    protected function pageContent(Page $page): array
    {
        if ($this->previewing()) {
            $draft = session('page_draft_'.$page->id);

            if (is_array($draft)) {
                return $draft;
            }
        }

        return $page->content ?? [];
    }

    protected function renderPage(Page $page): Response
    {
        $active = app(\App\Support\ActiveLocale::class);

        $sadrzaj = \App\Support\GlobalBlocks::resolve($this->pageContent($page));
        $resolved = \App\Support\BlockContent::resolve($sadrzaj, $active->language());

        if ($active->isCyrillic()) {
            $resolved = \App\Support\Cyrillic::deep($resolved);
        }

        $blocks = collect($resolved)->map(function (array $block) use ($page) {
            $type = $block['type'] ?? null;

            if ($type === 'card_grid') {
                $block['data']['items'] = $this->cards($block['data'] ?? []);
                $block['data']['to'] = ResourceUrls::forTarget($block['data']['cilj'] ?? null) ?: $this->lokalizujPutanju($block['data']['to'] ?? null);
            }

            if ($type === 'resource_list') {
                $block['data'] = $this->resourceList($block['data'] ?? [], $page);
            }

            if ($type === 'category_nav') {
                $block['data']['items'] = collect($block['data']['items'] ?? [])
                    ->map(function (array $stavka) {
                        $stavka['to'] = ResourceUrls::forTarget($stavka['cilj'] ?? null) ?: $this->lokalizujPutanju($stavka['to'] ?? null);

                        return $stavka;
                    })
                    ->filter(fn (array $stavka) => ! empty($stavka['to']))
                    ->values()
                    ->all();
            }

            if ($type === 'map') {
                $block['data']['items'] = MapPoints::all();
                $block['data']['to'] = ResourceUrls::forTarget($block['data']['cilj'] ?? null) ?: $this->lokalizujPutanju($block['data']['to'] ?? null);
            }

            if ($type === 'map_explorer') {
                $block['data']['items'] = MapPoints::all();
            }

            if ($type === 'related_content') {
                $block['data']['povezani'] = $this->povezaniSadrzaj();
            }

            if ($type === 'cta') {
                $block['data']['buttons'] = collect($block['data']['buttons'] ?? [])
                    ->map(function (array $dugme) {
                        $dugme['url'] = ResourceUrls::forTarget($dugme['cilj'] ?? null) ?: $this->lokalizujPutanju($dugme['url'] ?? null);

                        return $dugme;
                    })
                    ->all();
            }

            if ($type === 'featured_story') {
                $block['data']['item'] = $this->featuredStory($block['data'] ?? []);
            }

            return $block;
        })->all();

        request()->attributes->set('localizedPaths', collect(array_keys((array) config('locales.languages')))
            ->mapWithKeys(fn ($lang) => [$lang => $active->path($page->pathFor($lang), $lang)])
            ->all());

        $isHome = $page->isHome();
        $canonical = url($page->pathFor());

        return Inertia::render('PageRenderer', [
            'page' => [
                'title' => $page->title,
                'slug' => $page->slugFor(),
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
            ],
            'blocks' => $blocks,
            'seo' => Seo::make(
                $this->metaTitle($page),
                $page->meta_description,
                $canonical,
                $this->shareImage($page, $blocks),
                'website',
                [
                    Seo::breadcrumbs(
                        $isHome
                            ? [['name' => 'Početna', 'url' => '/']]
                            : [
                                ['name' => 'Početna', 'url' => '/'],
                                ['name' => $page->title, 'url' => $page->pathFor()],
                            ]
                    ),
                ],
            ),
        ]);
    }

    protected function metaTitle(Page $page): string
    {
        return ($page->meta_title !== null && $page->meta_title !== '') ? (string) $page->meta_title : (string) $page->title;
    }

    protected function lokalizujPutanju(?string $path): ?string
    {
        if (! $path || ! str_starts_with($path, '/') || str_starts_with($path, '//') || str_contains($path, '://')) {
            return $path;
        }

        $lang = app(\App\Support\ActiveLocale::class)->language();

        if ($lang === 'sr') {
            return $path;
        }

        $segmenti = array_values(array_filter(explode('/', $path), fn ($s) => $s !== ''));
        $izlaz = [];
        $roditeljId = null;

        foreach ($segmenti as $seg) {
            $stranica = Page::query()
                ->where('slug->sr', $seg)
                ->when($roditeljId, fn ($q) => $q->where('parent_id', $roditeljId), fn ($q) => $q->whereNull('parent_id'))
                ->first();

            if (! $stranica) {
                return $path;
            }

            $izlaz[] = $stranica->slugFor($lang);
            $roditeljId = $stranica->id;
        }

        return '/'.implode('/', $izlaz);
    }

    protected function siteName(): string
    {
        try {
            $brand = app(SiteSettings::class)->brand_naziv;
        } catch (\Throwable $e) {
            return '';
        }

        if (! is_array($brand)) {
            return (string) $brand;
        }

        $lang = app(\App\Support\ActiveLocale::class)->language();

        return $brand[$lang] ?? $brand['sr'] ?? '';
    }

    protected function shareImage(Page $page, array $blocks): ?string
    {
        $image = $page->og_image ?: $this->coverImage($blocks);

        if (! $image) {
            return null;
        }

        return str_starts_with($image, 'http') ? $image : url($image);
    }

    protected function coverImage(array $blocks): ?string
    {
        foreach ($blocks as $block) {
            if (($block['type'] ?? null) === 'hero' && ! empty($block['data']['image'])) {
                return $block['data']['image'];
            }
        }

        return null;
    }

    protected function resourceList(array $data, Page $page): array
    {
        $tip = ($data['resource'] ?? null) ?: ($page->resource_type ?: 'business');
        $cfg = ResourceUrls::config($tip) ?? ResourceUrls::config('business');

        $model = $cfg['model'];
        $resource = $cfg['resource'];

        $imaKategoriju = ! empty($cfg['category_type']);

        if ($tip === 'procurement') {
            $godine = $model::objavljeno()
                ->with('media')
                ->orderByDesc('godina')
                ->orderByDesc('datum')
                ->orderByDesc('id')
                ->get()
                ->groupBy(fn ($p) => $p->godina ?: 0)
                ->map(fn ($items, $g) => ['godina' => (int) $g, 'stavke' => $resource::collection($items)->resolve()])
                ->values();

            return [...$data, 'resource' => $tip, 'godine' => $godine, 'filteri' => false, 'pretraga' => false];
        }

        $prikaziFiltere = $imaKategoriju && (bool) ($data['filteri'] ?? false);
        $prikaziPretragu = (bool) ($data['pretraga'] ?? false);
        $perPage = max(1, (int) ($data['perPage'] ?? 12));

        $q = $prikaziPretragu ? trim((string) request()->query('q', '')) : '';
        $filterKat = $prikaziFiltere ? trim((string) request()->query('kategorija', '')) : '';

        $imaPeriod = in_array($tip, ['event', 'ad'], true) && $prikaziFiltere;
        $period = $imaPeriod ? (string) request()->query('period', '') : '';

        $query = $model::objavljeno()->with($imaKategoriju ? ['category', 'media'] : ['media']);

        if ($imaKategoriju && $page->category_id) {
            $query->where('category_id', $page->category_id);
        } elseif ($imaKategoriju && ! empty($data['kategorija'])) {
            $query->whereHas('category', fn ($c) => $c->byKeyOrSlug($data['kategorija']));
        }

        if ($imaKategoriju && $filterKat !== '') {
            $query->whereHas('category', fn ($c) => $c->byKeyOrSlug($filterKat));
        }

        if ($q !== '') {
            $this->pretrazi($query, (array) ($cfg['search'] ?? ['naslov']), $q);
        }

        $this->poredaj($query, $tip, array_merge($data, ['period' => $period]));

        $paginator = $query->paginate($perPage)->withQueryString();

        return [
            ...$data,
            'resource' => $tip,
            'filteri' => $prikaziFiltere,
            'pretraga' => $prikaziPretragu,
            'items' => $resource::collection($paginator->items())->resolve(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
            ],
            'kategorije' => $prikaziFiltere ? $this->kategorijeZaTip($tip) : [],
            'aktivnaKategorija' => $filterKat,
            'q' => $q,
            'periodi' => $imaPeriod ? $this->periodi($tip) : [],
            'aktivniPeriod' => $period,
            'kalendarStavke' => $this->kalendarStavke($tip, $data, $page, $model, $resource),
        ];
    }

    protected function kalendarStavke(string $tip, array $data, Page $page, string $model, string $resource): array
    {
        if ($tip !== 'event' || ! ($data['kalendar'] ?? false)) {
            return [];
        }

        $query = $model::objavljeno()->with(['category', 'media']);

        if ($page->category_id) {
            $query->where('category_id', $page->category_id);
        } elseif (! empty($data['kategorija'])) {
            $query->whereHas('category', fn ($c) => $c->byKeyOrSlug($data['kategorija']));
        }

        return $resource::collection($query->orderBy('datum')->get())->resolve();
    }

    protected function prevod(string $kljuc): string
    {
        $lang = app(\App\Support\ActiveLocale::class)->language();
        $poruke = app(\App\Support\Translations::class)->messages($lang);

        return (string) (data_get($poruke, $kljuc) ?: $kljuc);
    }

    protected function periodi(string $tip): array
    {
        if ($tip === 'event') {
            return [
                ['value' => '', 'label' => $this->prevod('events.upcoming')],
                ['value' => 'protekli', 'label' => $this->prevod('events.past')],
                ['value' => 'svi', 'label' => $this->prevod('events.allPeriods')],
            ];
        }

        return [
            ['value' => '', 'label' => $this->prevod('ads.active')],
            ['value' => 'istekli', 'label' => $this->prevod('ads.expired')],
            ['value' => 'svi', 'label' => $this->prevod('ads.allPeriods')],
        ];
    }

    protected function kategorijeZaTip(string $tip): array
    {
        $cfg = ResourceUrls::config($tip);

        return \App\Models\Category::query()
            ->where('type', $cfg['category_type'] ?? null)
            ->where('visible', true)
            ->orderBy('sort')
            ->get()
            ->map(fn ($c) => ['value' => $c->slugFor(), 'label' => $c->label])
            ->all();
    }

    protected function cards(array $data): array
    {
        $limit = (int) ($data['limit'] ?? 8);
        $kategorija = $data['kategorija'] ?? null;

        [$model, $resource] = match ($data['resource'] ?? 'business') {
            'location' => [Location::class, LocationResource::class],
            'event' => [Event::class, EventResource::class],
            'ad' => [Ad::class, AdResource::class],
            'story' => [Story::class, StoryResource::class],
            default => [Business::class, BusinessResource::class],
        };

        $tip = $data['resource'] ?? 'business';

        $query = $model::objavljeno()->with(['category', 'media']);

        if ($kategorija) {
            $query->whereHas('category', fn ($c) => $c->byKeyOrSlug($kategorija));
        }

        $this->poredaj($query, $tip, $data);

        return $resource::collection($query->limit($limit)->get())->resolve();
    }

    protected function pretrazi($query, array $polja, string $q): void
    {
        $jezici = array_unique([app(\App\Support\ActiveLocale::class)->language(), 'sr']);
        $pojam = '%'.$q.'%';

        $query->where(function ($builder) use ($polja, $jezici, $pojam) {
            foreach ($polja as $polje) {
                if (! preg_match('/^[a-z_]+$/', $polje)) {
                    continue;
                }

                foreach ($jezici as $lang) {
                    $builder->orWhereRaw(
                        "CONVERT(JSON_UNQUOTE(JSON_EXTRACT(`{$polje}`, ?)) USING utf8mb4) COLLATE utf8mb4_0900_ai_ci LIKE ?",
                        ['$."'.$lang.'"', $pojam],
                    );
                }
            }
        });
    }

    protected function poredaj($query, string $tip, array $data): void
    {
        if ($tip === 'event') {
            $period = $data['period'] ?? '';
            $sviDozvoljeni = $period === 'svi' || ($period === '' && ($data['ukljuciZavrsene'] ?? false));

            if ($period === 'protekli') {
                $query->where(fn ($q) => $q->where('zavrseno', true)->orWhereDate('datum', '<', now()->toDateString()));
                $query->orderByDesc('datum')->orderByDesc('id');

                return;
            }

            if (! $sviDozvoljeni) {
                $query->where('zavrseno', false)->whereDate('datum', '>=', now()->toDateString());
            }

            $query->orderBy('datum')->orderBy('vrijeme')->orderBy('id');

            return;
        }

        if ($tip === 'ad') {
            $period = $data['period'] ?? '';
            $sviDozvoljeni = $period === 'svi' || ($period === '' && ($data['ukljuciIstekle'] ?? false));

            if ($period === 'istekli') {
                $query->whereNotNull('rok')->whereDate('rok', '<', now()->toDateString());
                $query->orderByDesc('rok')->orderByDesc('id');

                return;
            }

            if (! $sviDozvoljeni) {
                $query->where(fn ($q) => $q->whereNull('rok')->orWhereDate('rok', '>=', now()->toDateString()));
            }

            $query->orderByRaw('rok IS NULL')->orderBy('rok')->orderByDesc('id');

            return;
        }

        if (in_array($tip, ['business', 'location'], true)) {
            $query->orderByDesc('preporuceno')->orderByDesc('published_at')->orderByDesc('id');

            return;
        }

        if ($tip === 'story') {
            $query->orderByDesc('published_at')->orderByDesc('datum')->orderByDesc('id');

            return;
        }

        if ($tip === 'news') {
            $query->orderByDesc('datum')->orderByDesc('published_at')->orderByDesc('id');

            return;
        }

        $query->orderByDesc('published_at')->orderByDesc('id');
    }

    protected function featuredStory(array $data): ?array
    {
        $query = Story::objavljeno()->with(['category', 'media']);

        if (! empty($data['slug'])) {
            $story = $query->where('slug', $data['slug'])->first();
        } else {
            $story = $query->where('featured', true)->latest('published_at')->first()
                ?? Story::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        }

        return $story ? (new StoryResource($story))->resolve() : null;
    }
}
