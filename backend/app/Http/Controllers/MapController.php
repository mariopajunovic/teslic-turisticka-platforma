<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusinessResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\LocationResource;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Support\MapPoints;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class MapController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Map', [
            'tacke' => MapPoints::all(),
            'povezani' => $this->povezani(),
            'seo' => Seo::make(
                'Mapa ponude',
                'Interaktivna mapa turističke ponude, biznisa i događaja Teslića.',
                url('/mapa'),
            ),
        ]);
    }

    protected function povezani(): array
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
}
