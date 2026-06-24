<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoryResource;
use App\Models\Category;
use App\Models\Story;
use App\Support\Seo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StoryController extends Controller
{
    public function index(Request $request): Response
    {
        $kategorija = $request->query('kategorija');
        $q = $request->query('q');

        $query = Story::objavljeno()
            ->with(['category', 'media'])
            ->latest('published_at');

        if ($kategorija) {
            $query->whereHas('category', fn ($c) => $c->where('key', $kategorija));
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
            'seo' => Seo::make(
                'Priče iz Teslića',
                'Čitajte zanimljive priče, reportaže i putopise s područja Teslića i Bosne.',
                url('/price'),
            ),
        ]);
    }

    public function show(string $slug): Response
    {
        $prica = Story::objavljeno()
            ->with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $slicne = Story::objavljeno()
            ->with(['category', 'media'])
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
                url('/price/'.$prica->slug),
                $prica->getFirstMediaUrl('naslovna'),
                'article',
                [
                    Seo::article($prica),
                    Seo::breadcrumbs([
                        ['name' => 'Početna', 'url' => '/'],
                        ['name' => 'Priče', 'url' => '/price'],
                        ['name' => $prica->naslov, 'url' => '/price/'.$prica->slug],
                    ]),
                ],
            ),
        ]);
    }

    public function kategorija(string $kategorija): Response
    {
        $cat = Category::where('key', $kategorija)->firstOrFail();

        $query = Story::objavljeno()
            ->with(['category', 'media'])
            ->latest('published_at')
            ->whereHas('category', fn ($c) => $c->where('key', $kategorija));

        $paginator = $query->paginate(12);

        return Inertia::render('StoriesListing', [
            'price' => [
                'data' => StoryResource::collection($paginator->items()),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                ],
            ],
            'kategorija' => $kategorija,
            'q' => null,
            'seo' => Seo::make(
                $cat->label.' — Teslić',
                'Čitajte priče u kategoriji '.$cat->label.' s područja Teslića.',
                url('/price/kategorija/'.$kategorija),
            ),
        ]);
    }
}
