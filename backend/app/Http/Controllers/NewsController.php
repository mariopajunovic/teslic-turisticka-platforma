<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Support\ResourceUrls;
use App\Support\Seo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(): Response
    {
        $vijesti = News::objavljeno()
            ->with('media')
            ->latest('datum')
            ->latest('id')
            ->paginate(12);

        return Inertia::render('NewsListing', [
            'vijesti' => NewsResource::collection($vijesti),
            'seo' => Seo::make(
                'Vijesti',
                'Novosti, servisna obavještenja i izvještaji Turističke organizacije Grada Teslića.',
                url('/vijesti'),
            ),
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $vijest = News::objavljeno()
            ->with('media')
            ->whereSlug($slug)
            ->firstOrFail();

        $request->attributes->set('localizedSlugs', (array) $vijest->slug);
        $request->attributes->set('localizedPaths', collect(array_keys((array) config('locales.languages')))
            ->mapWithKeys(fn ($lang) => [$lang => ResourceUrls::detail($vijest, $lang)])
            ->all());

        $slicne = News::objavljeno()
            ->with('media')
            ->where('id', '!=', $vijest->id)
            ->latest('datum')
            ->limit(3)
            ->get();

        return Inertia::render('NewsDetail', [
            'slug' => $slug,
            'vijest' => new NewsResource($vijest),
            'slicne' => NewsResource::collection($slicne),
            'nazad' => ['url' => '/vijesti', 'label' => 'Vijesti'],
            'seo' => Seo::make(
                $vijest->naslov,
                $vijest->izvod ?: $vijest->sadrzaj,
                url(ResourceUrls::detail($vijest)),
                $vijest->getFirstMediaUrl('naslovna'),
                'article',
            ),
        ]);
    }
}
