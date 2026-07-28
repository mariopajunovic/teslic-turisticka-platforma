<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    protected array $tipovi = [
        'business' => ['label' => 'Biznisi', 'komponenta' => 'BusinessCard'],
        'location' => ['label' => 'Lokaliteti', 'komponenta' => 'LocationCard'],
        'event' => ['label' => 'Događaji', 'komponenta' => 'EventCard'],
        'story' => ['label' => 'Priče', 'komponenta' => 'StoryCard'],
        'ad' => ['label' => 'Oglasi', 'komponenta' => 'AdCard'],
        'news' => ['label' => 'Vijesti', 'komponenta' => 'NewsCard'],
    ];

    public function index(Request $request): Response
    {
        $q = trim((string) $request->query('q', ''));

        $grupe = [];
        $ukupno = 0;

        if (mb_strlen($q) >= 2) {
            foreach ($this->tipovi as $tip => $meta) {
                $cfg = config('resources.types.'.$tip);

                if (! $cfg) {
                    continue;
                }

                $model = $cfg['model'];
                $resource = $cfg['resource'];
                $kolone = $cfg['search'] ?? ['naslov'];

                $items = $model::objavljeno()
                    ->where(function ($w) use ($kolone, $q) {
                        foreach ($kolone as $col) {
                            $w->orWhereRaw('CAST('.$col.' AS CHAR) COLLATE utf8mb4_unicode_ci LIKE ?', ['%'.$q.'%']);
                        }
                    })
                    ->latest()
                    ->limit(12)
                    ->get();

                if ($items->isNotEmpty()) {
                    $ukupno += $items->count();
                    $grupe[] = [
                        'tip' => $tip,
                        'label' => $meta['label'],
                        'komponenta' => $meta['komponenta'],
                        'items' => $resource::collection($items)->resolve($request),
                    ];
                }
            }
        }

        return Inertia::render('Search', [
            'q' => $q,
            'grupe' => $grupe,
            'ukupno' => $ukupno,
            'seo' => Seo::make(
                'Pretraga'.($q !== '' ? ': '.$q : ''),
                null,
                url()->current(),
            ),
        ]);
    }
}
