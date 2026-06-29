<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusinessResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\StoryResource;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\Story;
use App\Support\Seo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function index(Request $request): Response
    {
        $q = $request->query('q');
        $period = $request->query('period');

        $query = Event::objavljeno()
            ->with(['category', 'media'])
            ->orderBy('datum');

        if ($period === 'nadolazeci') {
            $query->where('zavrseno', false);
        } elseif ($period === 'protekli') {
            $query->where('zavrseno', true);
        }

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('naslov', 'like', '%'.$q.'%')
                    ->orWhere('lokacija', 'like', '%'.$q.'%');
            });
        }

        $paginator = $query->paginate(12)->withQueryString();

        return Inertia::render('Events', [
            'dogadjaji' => [
                'data' => EventResource::collection($paginator->items()),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                ],
            ],
            'q' => $q,
            'period' => $period,
            'povezani' => $this->povezani(),
            'seo' => Seo::make(
                'Događaji i dešavanja',
                'Pratite kulturne, sportske i zabavne događaje u Tesliću i okolini.',
                url('/dogadjaji'),
            ),
        ]);
    }

    protected function povezani(): array
    {
        $lokalitet = Location::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $biznis = Business::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        $prica = Story::objavljeno()->with(['category', 'media'])->latest('published_at')->first();

        return [
            'lokalitet' => $lokalitet ? (new LocationResource($lokalitet))->resolve() : null,
            'biznis' => $biznis ? (new BusinessResource($biznis))->resolve() : null,
            'prica' => $prica ? (new StoryResource($prica))->resolve() : null,
        ];
    }

    public function show(string $slug): Response
    {
        $dogadjaj = Event::objavljeno()
            ->with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $slicni = Event::objavljeno()
            ->with(['category', 'media'])
            ->where('id', '!=', $dogadjaj->id)
            ->limit(3)
            ->get();

        return Inertia::render('EventDetail', [
            'slug' => $slug,
            'dogadjaj' => new EventResource($dogadjaj),
            'slicni' => EventResource::collection($slicni),
            'povezani' => \App\Support\RelatedLinks::for($dogadjaj),
            'seo' => Seo::make(
                $dogadjaj->naslov,
                $dogadjaj->opis ?: $dogadjaj->opis_dug,
                url('/dogadjaji/'.$dogadjaj->slug),
                $dogadjaj->getFirstMediaUrl('naslovna'),
                'article',
                [
                    Seo::event($dogadjaj),
                    Seo::breadcrumbs([
                        ['name' => 'Početna', 'url' => '/'],
                        ['name' => 'Događaji', 'url' => '/dogadjaji'],
                        ['name' => $dogadjaj->naslov, 'url' => '/dogadjaji/'.$dogadjaj->slug],
                    ]),
                ],
            ),
        ]);
    }
}
