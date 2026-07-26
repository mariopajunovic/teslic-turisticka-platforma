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
use App\Support\ResourceUrls;

class StoryController extends Controller
{
    public function index(Request $request): Response
    {
        $kategorija = $request->query('kategorija');
        $q = $request->query('q');

        $query = Story::objavljeno()
            ->with(['category', 'media', 'user'])
            ->latest('published_at');

        if ($kategorija) {
            $query->whereHas('category', fn ($c) => $c->byKeyOrSlug($kategorija));
        }

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('naslov', 'like', '%'.$q.'%')
                    ->orWhere('izvod', 'like', '%'.$q.'%');
            });
        }

        $paginator = $query->paginate(12)->withQueryString();

        return Inertia::render('StoriesListing', [
            'price' => [
                'data' => StoryResource::collection($paginator->items()),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                ],
            ],
            'kategorija' => $kategorija,
            'q' => $q,
            'povezani' => $this->povezani(),
            'seo' => Seo::make(
                'Priče iz Teslića',
                'Čitajte zanimljive priče, reportaže i putopise s područja Teslića i Bosne.',
                url('/price'),
            ),
        ]);
    }

    protected function povezani(): array
    {
        $biznis = Business::objavljeno()->with(['category', 'media', 'user'])->latest('published_at')->first();
        $lokalitet = Location::objavljeno()->with(['category', 'media', 'user'])->latest('published_at')->first();
        $dogadjaj = Event::objavljeno()->with(['category', 'media', 'user'])->latest('published_at')->first();

        return [
            'biznis' => $biznis ? (new BusinessResource($biznis))->resolve() : null,
            'lokalitet' => $lokalitet ? (new LocationResource($lokalitet))->resolve() : null,
            'dogadjaj' => $dogadjaj ? (new EventResource($dogadjaj))->resolve() : null,
        ];
    }

    public function show(Request $request, string $slug): Response
    {
        $prica = Story::objavljeno()
            ->with(['category', 'media', 'user'])
            ->whereSlug($slug)
            ->firstOrFail();

        $request->attributes->set('localizedPaths', collect(array_keys((array) config('locales.languages')))
            ->mapWithKeys(fn ($lang) => [$lang => ResourceUrls::detail($prica, $lang)])
            ->all());

        $slicne = Story::objavljeno()
            ->with(['category', 'media', 'user'])
            ->where('id', '!=', $prica->id)
            ->limit(3)
            ->get();

        return Inertia::render('StoryDetail', [
            'slug' => $slug,
            'prica' => new StoryResource($prica),
            'slicne' => StoryResource::collection($slicne),
            'povezani' => \App\Support\RelatedLinks::for($prica),
            'seo' => Seo::make(
                $prica->naslov,
                $prica->izvod,
                url(ResourceUrls::detail($prica)),
                $prica->getFirstMediaUrl('naslovna'),
                'article',
                [
                    Seo::article($prica),
                    Seo::breadcrumbs([
                        ['name' => 'Početna', 'url' => '/'],
                        ['name' => 'Priče', 'url' => '/price'],
                        ['name' => $prica->naslov, 'url' => ResourceUrls::detail($prica)],
                    ]),
                ],
            ),
        ]);
    }

    public function kategorija(Request $request, string $kategorija): Response
    {
        $cat = Category::byKeyOrSlug($kategorija)->firstOrFail();
        $q = $request->query('q');

        $query = Story::objavljeno()
            ->with(['category', 'media', 'user'])
            ->latest('published_at')
            ->whereHas('category', fn ($c) => $c->byKeyOrSlug($kategorija));

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('naslov', 'like', '%'.$q.'%')
                    ->orWhere('izvod', 'like', '%'.$q.'%');
            });
        }

        $paginator = $query->paginate(12)->withQueryString();

        return Inertia::render('StoriesListing', [
            'price' => [
                'data' => StoryResource::collection($paginator->items()),
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
                $cat->meta_description ?: 'Čitajte priče u kategoriji '.$cat->label.' s područja Teslića.',
                url('/price/kategorija/'.$kategorija),
            ),
        ]);
    }
}
