<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Category;
use App\Models\Location;
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
            'seo' => Seo::make(
                'Turizam u Tesliću',
                'Otkrijte prirodne ljepote, kulturne znamenitosti i turističke atrakcije Teslića i okoline.',
                url('/turizam'),
            ),
        ]);
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
            'q' => $q,
            'seo' => Seo::make(
                $cat->label.' — Teslić',
                'Pregledajte turističke lokalitete u kategoriji '.$cat->label.' na području Teslića.',
                url('/turizam/kategorija/'.$kategorija),
            ),
        ]);
    }
}
