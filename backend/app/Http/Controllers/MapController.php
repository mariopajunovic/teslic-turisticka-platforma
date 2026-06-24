<?php

namespace App\Http\Controllers;

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
            'seo' => Seo::make(
                'Mapa ponude',
                'Interaktivna mapa turističke ponude, biznisa i događaja Teslića.',
                url('/mapa'),
            ),
        ]);
    }
}
