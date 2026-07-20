<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusinessResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\StoryResource;
use App\Models\Business;
use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use App\Models\Story;
use App\Support\RelatedLinks;
use App\Support\Seo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Support\ResourceUrls;

class BusinessController extends Controller
{
    public function index(Request $request): Response
    {
        $kategorija = $request->query('kategorija');
        $q = $request->query('q');

        $query = Business::objavljeno()
            ->with(['category', 'media'])
            ->latest('published_at');

        if ($kategorija) {
            $query->whereHas('category', fn ($c) => $c->byKeyOrSlug($kategorija));
        }

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('naslov', 'like', '%'.$q.'%')
                    ->orWhere('opis', 'like', '%'.$q.'%')
                    ->orWhere('lokacija', 'like', '%'.$q.'%');
            });
        }

        $paginator = $query->paginate(12)->withQueryString();

        return Inertia::render('LocalListing', [
            'biznisi' => [
                'data' => BusinessResource::collection($paginator->items()),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                ],
            ],
            'kategorija' => $kategorija,
            'q' => $q,
            'povezani' => $this->povezani(),
            'seo' => Seo::make(
                'Domaće je najbolje - lokalni proizvodi i usluge',
                'Otkrijte zanate, domaću hranu i piće te pouzdane usluge iz Teslića i okoline.',
                url('/domace-je-najbolje'),
            ),
        ]);
    }

    protected function povezani(): array
    {
        $lokalitet = Location::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $prica = Story::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $dogadjaj = Event::objavljeno()->with(['category', 'media'])->latest('published_at')->first();

        return [
            'lokalitet' => $lokalitet ? (new LocationResource($lokalitet))->resolve() : null,
            'prica' => $prica ? (new StoryResource($prica))->resolve() : null,
            'dogadjaj' => $dogadjaj ? (new EventResource($dogadjaj))->resolve() : null,
        ];
    }

    public function show(Request $request, string $slug): Response
    {
        $biznis = Business::objavljeno()
            ->with(['category', 'media'])
            ->whereSlug($slug)
            ->firstOrFail();

        $request->attributes->set('localizedSlugs', (array) $biznis->slug);
        $request->attributes->set('localizedPaths', collect(array_keys((array) config('locales.languages')))
            ->mapWithKeys(fn ($lang) => [$lang => ResourceUrls::detail($biznis, $lang)])
            ->all());

        $slicni = Business::objavljeno()
            ->with(['category', 'media'])
            ->where('id', '!=', $biznis->id)
            ->where('category_id', $biznis->category_id)
            ->limit(3)
            ->get();

        $kolekcija = \App\Models\Page::query()
            ->where('resource_type', 'business')
            ->whereNull('category_id')
            ->orderBy('id')
            ->first();

        return Inertia::render('BusinessProfile', [
            'slug' => $slug,
            'biznis' => new BusinessResource($biznis),
            'slicni' => BusinessResource::collection($slicni),
            'povezani' => RelatedLinks::for($biznis),
            'otvoreno' => $this->otvorenoSad((array) $biznis->radno_vrijeme),
            'nazad' => [
                'url' => ResourceUrls::collection('business') ?: '/',
                'label' => $kolekcija?->naslov,
            ],
            'seo' => Seo::make(
                $biznis->naslov,
                $biznis->opis ?: $biznis->opis_dug,
                url(ResourceUrls::detail($biznis)),
                $biznis->getFirstMediaUrl('naslovna'),
                'article',
                [
                    Seo::localBusiness($biznis),
                    Seo::breadcrumbs([
                        ['name' => 'Početna', 'url' => '/'],
                        ['name' => 'Domaće je najbolje', 'url' => '/domace-je-najbolje'],
                        ['name' => $biznis->naslov, 'url' => ResourceUrls::detail($biznis)],
                    ]),
                ],
            ),
        ]);
    }

    protected function otvorenoSad(array $dani): ?bool
    {
        if (empty($dani)) {
            return null;
        }

        $now = \Illuminate\Support\Carbon::now('Europe/Sarajevo');
        $dan = $dani[$now->dayOfWeekIso - 1] ?? null;

        if (! $dan || ! empty($dan['zatvoreno']) || empty($dan['od']) || empty($dan['do'])) {
            return false;
        }

        $sad = (int) $now->format('Hi');
        $od = (int) str_replace(':', '', $dan['od']);
        $do = (int) str_replace(':', '', $dan['do']);

        return $do <= $od ? ($sad >= $od || $sad < $do) : ($sad >= $od && $sad < $do);
    }

    public function kategorija(Request $request, string $kategorija): Response
    {
        $cat = Category::byKeyOrSlug($kategorija)->firstOrFail();
        $q = $request->query('q');

        $query = Business::objavljeno()
            ->with(['category', 'media'])
            ->latest('published_at')
            ->whereHas('category', fn ($c) => $c->byKeyOrSlug($kategorija));

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('naslov', 'like', '%'.$q.'%')
                    ->orWhere('opis', 'like', '%'.$q.'%')
                    ->orWhere('lokacija', 'like', '%'.$q.'%');
            });
        }

        $paginator = $query->paginate(12)->withQueryString();

        return Inertia::render('LocalListing', [
            'biznisi' => [
                'data' => BusinessResource::collection($paginator->items()),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                ],
            ],
            'kategorija' => $kategorija,
            'kategorijaLabel' => $cat->label,
            'kategorijaOpis' => $cat->opis,
            'kategorijaHero' => $this->categoryHero($cat),
            'q' => $q,
            'povezani' => $this->povezani(),
            'seo' => Seo::make(
                $cat->meta_title ?: $cat->label.' - Teslić',
                $cat->meta_description ?: 'Pregledajte lokalne proizvode i usluge u kategoriji '.$cat->label.' iz Teslića i okoline.',
                url('/domace-je-najbolje/kategorija/'.$kategorija),
            ),
        ]);
    }
}
