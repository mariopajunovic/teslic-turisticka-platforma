<?php

namespace App\Http\Controllers;

use App\Support\MapPoints;
use Inertia\Inertia;
use Inertia\Response;

class MapController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Map', [
            'tacke' => MapPoints::all(),
        ]);
    }
}
