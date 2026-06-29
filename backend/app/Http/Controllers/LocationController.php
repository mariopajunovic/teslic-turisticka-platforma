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
use App\Support\Seo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LocationController extends Controller
{
    public function index(Request $request): Response
    {
        $kategorija = $request->query('kategorija');
        $q = $request->query('q');

        $query = Location::objavljeno()
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

        return Inertia::render('TourismListing', [
            'lokaliteti' => [
                'data' => LocationResource::collection($paginator->items()),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                ],
            ],
            'kategorija' => $kategorija,
            'q' => $q,
            'povezani' => $this->povezani(),
            'seo' => Seo::make(
                'Turizam u Tesliću',
                'Otkrijte prirodne ljepote, kulturne znamenitosti i turističke atrakcije Teslića i okoline.',
                url('/turizam'),
            ),
        ]);
    }

    protected function povezani(): array
    {
        $biznis = Business::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $dogadjaj = Event::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $prica = Story::objavljeno()->with(['category', 'media'])->latest('published_at')->first();

        return [
            'biznis' => $biznis ? (new BusinessResource($biznis))->resolve() : null,
            'dogadjaj' => $dogadjaj ? (new EventResource($dogadjaj))->resolve() : null,
            'prica' => $prica ? (new StoryResource($prica))->resolve() : null,
        ];
    }

    public function show(string $slug): Response
    {
        $lokalitet = Location::objavljeno()
            ->with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $slicni = Location::objavljeno()
            ->with(['category', 'media'])
            ->where('id', '!=', $lokalitet->id)
            ->limit(3)
            ->get();

        return Inertia::render('LocationDetail', [
            'slug' => $slug,
            'lokalitet' => new LocationResource($lokalitet),
            'slicni' => LocationResource::collection($slicni),
            'povezani' => \App\Support\RelatedLinks::for($lokalitet),
            'seo' => Seo::make(
                $lokalitet->naslov,
                $lokalitet->opis ?: $lokalitet->opis_dug,
                url('/turizam/'.$lokalitet->slug),
                $lokalitet->getFirstMediaUrl('naslovna'),
                'article',
                [
                    Seo::breadcrumbs([
                        ['name' => 'Početna', 'url' => '/'],
                        ['name' => 'Turizam', 'url' => '/turizam'],
                        ['name' => $lokalitet->naslov, 'url' => '/turizam/'.$lokalitet->slug],
                    ]),
                ],
            ),
        ]);
    }

    public function kategorija(Request $request, string $kategorija): Response
    {
        $cat = Category::where('key', $kategorija)->firstOrFail();
        $q = $request->query('q');

        $query = Location::objavljeno()
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

        return Inertia::render('TourismListing', [
            'lokaliteti' => [
                'data' => LocationResource::collection($paginator->items()),
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
                $cat->meta_description ?: 'Pregledajte turističke lokalitete u kategoriji '.$cat->label.' na području Teslića.',
                url('/turizam/kategorija/'.$kategorija),
            ),
        ]);
    }
}
