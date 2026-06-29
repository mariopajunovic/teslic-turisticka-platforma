<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\StoryResource;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Location;
use App\Models\Story;
use App\Support\Seo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdController extends Controller
{
    public function index(Request $request): Response
    {
        $kategorija = $request->query('kategorija');
        $q = $request->query('q');
        $status = $request->query('status', 'aktivni');

        $query = Ad::objavljeno()
            ->with(['category'])
            ->latest('published_at');

        if ($status === 'arhiva') {
            $query->where('rok', '<', now());
        } else {
            $query->where(function ($b) {
                $b->whereNull('rok')->orWhere('rok', '>=', now());
            });
        }

        if ($kategorija) {
            $query->whereHas('category', fn ($c) => $c->where('key', $kategorija));
        }

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('naslov', 'like', '%'.$q.'%')
                    ->orWhere('izdavac', 'like', '%'.$q.'%')
                    ->orWhere('lokacija', 'like', '%'.$q.'%');
            });
        }

        $paginator = $query->paginate(12)->withQueryString();

        return Inertia::render('AdsListing', [
            'oglasi' => [
                'data' => AdResource::collection($paginator->items()),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                ],
            ],
            'kategorija' => $kategorija,
            'q' => $q,
            'status' => $status,
            'povezani' => $this->povezani(),
            'seo' => Seo::make(
                'Poslovne prilike i oglasi',
                'Pregledajte poslovne prilike, konkurse i oglase objavljene za područje Teslića.',
                url('/oglasi'),
            ),
        ]);
    }

    protected function povezani(): array
    {
        $biznis = Business::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $lokalitet = Location::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $prica = Story::objavljeno()->with(['category', 'media'])->latest('published_at')->first();

        return [
            'biznis' => $biznis ? (new BusinessResource($biznis))->resolve() : null,
            'lokalitet' => $lokalitet ? (new LocationResource($lokalitet))->resolve() : null,
            'prica' => $prica ? (new StoryResource($prica))->resolve() : null,
        ];
    }

    public function show(string $slug): Response
    {
        $oglas = Ad::objavljeno()
            ->with(['category'])
            ->where('slug', $slug)
            ->firstOrFail();

        $slicni = Ad::objavljeno()
            ->with(['category'])
            ->where('id', '!=', $oglas->id)
            ->where('category_id', $oglas->category_id)
            ->limit(3)
            ->get();

        return Inertia::render('AdDetail', [
            'slug' => $slug,
            'oglas' => new AdResource($oglas),
            'slicni' => AdResource::collection($slicni),
            'povezani' => \App\Support\RelatedLinks::for($oglas),
            'seo' => Seo::make(
                $oglas->naslov,
                $oglas->opis_dug ?: null,
                url('/oglasi/'.$oglas->slug),
                $oglas->getFirstMediaUrl('naslovna'),
                'article',
                [
                    Seo::breadcrumbs([
                        ['name' => 'Početna', 'url' => '/'],
                        ['name' => 'Oglasi', 'url' => '/oglasi'],
                        ['name' => $oglas->naslov, 'url' => '/oglasi/'.$oglas->slug],
                    ]),
                ],
            ),
        ]);
    }
}
