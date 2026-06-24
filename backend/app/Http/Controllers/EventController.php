<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function index(): Response
    {
        $dogadjaji = Event::objavljeno()
            ->with(['category', 'media'])
            ->orderBy('datum')
            ->get();

        return Inertia::render('Events', [
            'dogadjaji' => EventResource::collection($dogadjaji),
        ]);
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
        ]);
    }
}
