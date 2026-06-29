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
            $query->whereHas('category', fn ($c) => $c->where('key', $kategorija));
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
                'Domaće je najbolje — lokalni proizvodi i usluge',
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

    public function show(string $slug): Response
    {
        $biznis = Business::objavljeno()
            ->with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $slicni = Business::objavljeno()
            ->with(['category', 'media'])
            ->where('id', '!=', $biznis->id)
            ->where('category_id', $biznis->category_id)
            ->limit(3)
            ->get();

        return Inertia::render('BusinessProfile', [
            'slug' => $slug,
            'biznis' => new BusinessResource($biznis),
            'slicni' => BusinessResource::collection($slicni),
            'povezani' => RelatedLinks::for($biznis),
            'seo' => Seo::make(
                $biznis->naslov,
                $biznis->opis ?: $biznis->opis_dug,
                url('/domace-je-najbolje/'.$biznis->slug),
                $biznis->getFirstMediaUrl('naslovna'),
                'article',
                [
                    Seo::localBusiness($biznis),
                    Seo::breadcrumbs([
                        ['name' => 'Početna', 'url' => '/'],
                        ['name' => 'Domaće je najbolje', 'url' => '/domace-je-najbolje'],
                        ['name' => $biznis->naslov, 'url' => '/domace-je-najbolje/'.$biznis->slug],
                    ]),
                ],
            ),
        ]);
    }

    public function kategorija(Request $request, string $kategorija): Response
    {
        $cat = Category::where('key', $kategorija)->firstOrFail();
        $q = $request->query('q');

        $query = Business::objavljeno()
            ->with(['category', 'media'])
            ->latest('published_at')
            ->whereHas('category', fn ($c) => $c->where('key', $kategorija));

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
                $cat->meta_title ?: $cat->label.' — Teslić',
                $cat->meta_description ?: 'Pregledajte lokalne proizvode i usluge u kategoriji '.$cat->label.' iz Teslića i okoline.',
                url('/domace-je-najbolje/kategorija/'.$kategorija),
            ),
        ]);
    }
}
