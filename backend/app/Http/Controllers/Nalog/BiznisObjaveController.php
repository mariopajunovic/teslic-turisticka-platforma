<?php

namespace App\Http\Controllers\Nalog;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessObjavaRequest;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BiznisObjaveController extends Controller
{
    public function index(): Response
    {
        $objave = Business::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->get()
            ->map(fn (Business $b) => [
                'id' => $b->id,
                'naslov' => $b->naslov,
                'meta' => $b->status->getLabel().($b->category ? ' · '.$b->category->label : ''),
                'status' => $b->status->badge(),
                'reason' => $b->status === ContentStatus::Odbijeno ? $b->rejection_reason : null,
                'editUrl' => "/nalog/biznis/objave/{$b->id}/uredi",
            ]);

        return Inertia::render('account/BiznisObjave', ['objave' => $objave]);
    }

    public function pregled(): Response
    {
        $objave = Business::where('user_id', auth()->id())->get();

        return Inertia::render('account/BiznisPregled', [
            'korisnik' => auth()->user()->name,
            'stats' => [
                'ukupno' => $objave->count(),
                'objavljeno' => $objave->where('status', ContentStatus::Objavljeno)->count(),
                'naCekanju' => $objave->where('status', ContentStatus::Poslano)->count(),
                'nacrt' => $objave->where('status', ContentStatus::Nacrt)->count(),
                'odbijeno' => $objave->where('status', ContentStatus::Odbijeno)->count(),
            ],
            'odbijeni' => $objave->where('status', ContentStatus::Odbijeno)->map(fn (Business $b) => [
                'naslov' => $b->naslov,
                'razlog' => $b->rejection_reason,
                'editUrl' => "/nalog/biznis/objave/{$b->id}/uredi",
            ])->values()->all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('account/BiznisObjavaForm', [
            'objava' => null,
            'kategorije' => $this->categories(),
        ]);
    }

    public function edit(Business $business): Response
    {
        $this->authorizeOwner($business);

        return Inertia::render('account/BiznisObjavaForm', [
            'objava' => [
                'id' => $business->id,
                'naslov' => $business->naslov,
                'category_id' => $business->category_id,
                'opis' => $business->opis,
                'opis_dug' => $business->opis_dug,
                'lokacija' => $business->lokacija,
                'kontakt' => $business->kontakt ?? [],
                'drustvene' => $business->drustvene ?? [],
                'usluge' => implode("\n", $business->getTranslations('usluge')['sr'] ?? []),
                'nacin_placanja' => $business->nacin_placanja ?? [],
                'cijena_raspon' => $business->cijena_raspon,
                'godina_osnivanja' => $business->godina_osnivanja,
                'jib' => $business->jib,
                'radno_vrijeme' => $business->radno_vrijeme ?: [],
                'lat' => $business->lat,
                'lng' => $business->lng,
                'status' => $business->status->badge(),
                'naslovna' => $business->getFirstMediaUrl('naslovna') ?: null,
                'galerija' => $business->getMedia('galerija')->map(fn (Media $m) => [
                    'id' => $m->id,
                    'src' => $m->getUrl(),
                ])->all(),
            ],
            'kategorije' => $this->categories(),
        ]);
    }

    public function store(BusinessObjavaRequest $request): RedirectResponse
    {
        $business = new Business(['user_id' => auth()->id()]);
        $this->fill($business, $request);

        return redirect("/nalog/biznis/objave/{$business->id}/uredi")
            ->with('status', $this->message($business));
    }

    public function update(BusinessObjavaRequest $request, Business $business): RedirectResponse
    {
        $this->authorizeOwner($business);
        $this->fill($business, $request);

        return redirect("/nalog/biznis/objave/{$business->id}/uredi")
            ->with('status', $this->message($business));
    }

    public function destroyMedia(Media $media): RedirectResponse
    {
        abort_unless(
            $media->model_type === Business::class
            && Business::where('id', $media->model_id)->where('user_id', auth()->id())->exists(),
            403
        );

        $media->delete();

        return back()->with('status', 'Fotografija je uklonjena.');
    }

    protected function fill(Business $business, BusinessObjavaRequest $request): void
    {
        $data = $request->validated();

        $business->fill([
            'naslov' => $data['naslov'],
            'category_id' => $data['category_id'] ?? null,
            'opis' => $data['opis'] ?? null,
            'opis_dug' => $data['opis_dug'] ?? null,
            'lokacija' => $data['lokacija'] ?? null,
            'kontakt' => $data['kontakt'] ?? null,
            'drustvene' => $this->drustvene($data['drustvene'] ?? []),
            'nacin_placanja' => array_filter([
                'gotovina' => (bool) ($data['nacin_placanja']['gotovina'] ?? false),
                'kartica' => (bool) ($data['nacin_placanja']['kartica'] ?? false),
                'virman' => (bool) ($data['nacin_placanja']['virman'] ?? false),
            ]),
            'cijena_raspon' => in_array($data['cijena_raspon'] ?? '', ['€', '€€', '€€€'], true) ? $data['cijena_raspon'] : null,
            'godina_osnivanja' => $data['godina_osnivanja'] ?? null,
            'jib' => $data['jib'] ?? null,
            'radno_vrijeme' => $this->radnoVrijeme($data['radno_vrijeme'] ?? []),
            'lat' => $data['lat'] ?? null,
            'lng' => $data['lng'] ?? null,
            'status' => $data['action'] === 'posalji' ? ContentStatus::Poslano : ContentStatus::Nacrt,
        ]);
        $business->setTranslations('usluge', ['sr' => $this->uslugeNiz($data['usluge'] ?? '')]);
        $business->save();

        if ($request->hasFile('naslovna')) {
            $business->addMediaFromRequest('naslovna')->toMediaCollection('naslovna');
        }

        foreach ($request->file('galerija', []) as $file) {
            $business->addMedia($file)->toMediaCollection('galerija');
        }
    }

    protected function drustvene(array $d): array
    {
        return collect(['facebook', 'instagram', 'youtube', 'tiktok'])
            ->mapWithKeys(fn ($k) => [$k => trim((string) ($d[$k] ?? ''))])
            ->all();
    }

    protected function radnoVrijeme(array $dani): array
    {
        return collect($dani)->take(7)->map(fn ($d) => [
            'zatvoreno' => (bool) ($d['zatvoreno'] ?? false),
            'od' => trim((string) ($d['od'] ?? '')),
            'do' => trim((string) ($d['do'] ?? '')),
        ])->values()->all();
    }

    protected function uslugeNiz(string $tekst): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $tekst))
            ->map(fn ($u) => trim($u))
            ->filter()
            ->values()
            ->all();
    }

    protected function message(Business $business): string
    {
        return $business->status === ContentStatus::Poslano
            ? 'Objava je poslana na odobrenje.'
            : 'Objava je sačuvana kao nacrt.';
    }

    protected function categories(): array
    {
        return Category::where('type', 'domace')
            ->orderBy('label')
            ->get()
            ->map(fn (Category $c) => ['value' => $c->id, 'label' => $c->label])
            ->all();
    }

    protected function authorizeOwner(Business $business): void
    {
        abort_unless($business->user_id === auth()->id(), 403);
    }
}
