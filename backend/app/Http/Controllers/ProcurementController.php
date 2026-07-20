<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProcurementResource;
use App\Models\Procurement;
use App\Support\ResourceUrls;
use App\Support\Seo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProcurementController extends Controller
{
    public function index(): Response
    {
        $godine = Procurement::objavljeno()
            ->with('media')
            ->orderByDesc('godina')
            ->orderByDesc('datum')
            ->orderByDesc('id')
            ->get()
            ->groupBy(fn (Procurement $p) => $p->godina ?: 0)
            ->map(fn ($items, $godina) => [
                'godina' => (int) $godina,
                'stavke' => ProcurementResource::collection($items)->resolve(),
            ])
            ->values();

        return Inertia::render('ProcurementListing', [
            'godine' => $godine,
            'seo' => Seo::make(
                'Javne nabavke',
                'Dokumentacija javnih nabavki Turističke organizacije Grada Teslića, razvrstana po godinama.',
                url('/javne-nabavke'),
            ),
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $nabavka = Procurement::objavljeno()
            ->with('media')
            ->whereSlug($slug)
            ->firstOrFail();

        $request->attributes->set('localizedSlugs', (array) $nabavka->slug);
        $request->attributes->set('localizedPaths', collect(array_keys((array) config('locales.languages')))
            ->mapWithKeys(fn ($lang) => [$lang => ResourceUrls::detail($nabavka, $lang)])
            ->all());

        return Inertia::render('ProcurementDetail', [
            'slug' => $slug,
            'nabavka' => new ProcurementResource($nabavka),
            'nazad' => ['url' => '/javne-nabavke', 'label' => 'Javne nabavke'],
            'seo' => Seo::make(
                $nabavka->naslov,
                $nabavka->opis,
                url(ResourceUrls::detail($nabavka)),
            ),
        ]);
    }
}
