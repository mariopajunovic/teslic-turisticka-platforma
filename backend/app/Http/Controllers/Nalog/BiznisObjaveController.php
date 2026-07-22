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
                'pendingStanje' => $b->pending === null ? null : ($b->pending_reason ? 'vraceno' : 'na_cekanju'),
                'pendingRazlog' => $b->pending_reason,
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

        $imaPending = $business->pending !== null;

        $data = $business->pending ?? [
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
        ];

        $galerijaPending = $imaPending && $business->getMedia('galerija_pending')->isNotEmpty();
        $galerija = $galerijaPending
            ? $business->getMedia('galerija_pending')
            : $business->getMedia('galerija');

        return Inertia::render('account/BiznisObjavaForm', [
            'objava' => array_merge($data, [
                'id' => $business->id,
                'status' => $business->status->badge(),
                'objavljeno' => $business->status === ContentStatus::Objavljeno,
                'imaPending' => $imaPending,
                'vraceno' => $business->pending_reason,
                'naslovna' => $imaPending && ($mp = $business->getFirstMedia('naslovna_pending'))
                    ? \App\Http\Controllers\SecureMediaController::url($mp)
                    : ($business->getFirstMediaUrl('naslovna') ?: null),
                'galerija' => $galerija->map(fn (Media $m) => [
                    'id' => $m->id,
                    'src' => $galerijaPending ? \App\Http\Controllers\SecureMediaController::url($m) : $m->getUrl(),
                ])->all(),
            ]),
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

        // Izmjena već objavljenog listinga -> ide na moderaciju; živa verzija ostaje aktivna.
        if ($business->exists && $business->status === ContentStatus::Objavljeno) {
            $business->pending = $this->pendingPayload($data);
            $business->pending_reason = null;
            $business->save();
            $this->stageMedia($business, $request);
            $this->obavijestiOrg($business, true);

            return;
        }

        $business->popuniIz($data);
        $business->status = $data['action'] === 'posalji' ? ContentStatus::Poslano : ContentStatus::Nacrt;
        $business->save();

        if ($request->hasFile('naslovna')) {
            $business->addMediaFromRequest('naslovna')->toMediaCollection('naslovna');
        }

        foreach ($request->file('galerija', []) as $file) {
            $business->addMedia($file)->toMediaCollection('galerija');
        }

        if ($business->status === ContentStatus::Poslano) {
            $this->obavijestiOrg($business, false);
        }
    }

    protected function obavijestiOrg(Business $business, bool $izmjena): void
    {
        \App\Support\OrgNotifier::send(new \App\Notifications\OrgSadrzajNaOdobrenju(
            'Biznis',
            (string) $business->naslov,
            (string) (auth()->user()->name ?? ''),
            $izmjena,
        ));
    }

    protected function pendingPayload(array $data): array
    {
        return collect($data)->only([
            'naslov', 'category_id', 'opis', 'opis_dug', 'lokacija', 'kontakt',
            'drustvene', 'usluge', 'nacin_placanja', 'cijena_raspon',
            'godina_osnivanja', 'jib', 'radno_vrijeme', 'lat', 'lng',
        ])->all();
    }

    protected function stageMedia(Business $business, BusinessObjavaRequest $request): void
    {
        if ($request->hasFile('naslovna')) {
            $business->addMediaFromRequest('naslovna')->toMediaCollection('naslovna_pending');
        }

        foreach ($request->file('galerija', []) as $file) {
            $business->addMedia($file)->toMediaCollection('galerija_pending');
        }
    }


    protected function message(Business $business): string
    {
        if ($business->pending !== null) {
            return 'Izmjene su poslane na odobrenje. Trenutna objava ostaje aktivna.';
        }

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
