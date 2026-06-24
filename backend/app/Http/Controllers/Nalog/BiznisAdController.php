<?php

namespace App\Http\Controllers\Nalog;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BiznisAdController extends Controller
{
    public function index(): Response
    {
        $oglasi = Ad::where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(fn (Ad $a) => [
                'id' => $a->id,
                'naslov' => $a->naslov,
                'meta' => $a->status->getLabel().($a->rok ? ' · Rok: '.$a->rok->format('d.m.Y.') : ''),
                'status' => $a->status->badge(),
                'reason' => $a->status === ContentStatus::Odbijeno ? $a->rejection_reason : null,
                'editUrl' => "/nalog/biznis/oglasi/{$a->id}/uredi",
            ]);

        return Inertia::render('account/BiznisOglasi', ['oglasi' => $oglasi]);
    }

    public function create(): Response
    {
        return Inertia::render('account/BiznisOglasForm', [
            'oglas' => null,
            'vrste' => $this->vrste(),
        ]);
    }

    public function edit(Ad $ad): Response
    {
        $this->authorizeOwner($ad);

        return Inertia::render('account/BiznisOglasForm', [
            'oglas' => [
                'id' => $ad->id,
                'naslov' => $ad->naslov,
                'category_id' => $ad->category_id,
                'izdavac' => $ad->izdavac,
                'lokacija' => $ad->lokacija,
                'rok' => $ad->rok?->format('Y-m-d'),
                'opis_dug' => $ad->opis_dug,
            ],
            'vrste' => $this->vrste(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $ad = new Ad(['user_id' => auth()->id()]);
        $this->fill($ad, $request);

        return $this->done($ad);
    }

    public function update(Request $request, Ad $ad): RedirectResponse
    {
        $this->authorizeOwner($ad);
        $this->fill($ad, $request);

        return $this->done($ad);
    }

    protected function fill(Ad $ad, Request $request): void
    {
        $data = $request->validate([
            'naslov' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'izdavac' => ['nullable', 'string', 'max:255'],
            'lokacija' => ['nullable', 'string', 'max:255'],
            'rok' => ['nullable', 'date'],
            'opis_dug' => ['nullable', 'string'],
            'action' => ['required', 'in:nacrt,posalji'],
        ]);

        $ad->fill([
            'naslov' => $data['naslov'],
            'category_id' => $data['category_id'] ?? null,
            'izdavac' => $data['izdavac'] ?? null,
            'lokacija' => $data['lokacija'] ?? null,
            'rok' => $data['rok'] ?? null,
            'opis_dug' => $data['opis_dug'] ?? null,
            'status' => $data['action'] === 'posalji' ? ContentStatus::Poslano : ContentStatus::Nacrt,
        ]);
        $ad->save();
    }

    protected function done(Ad $ad): RedirectResponse
    {
        return redirect('/nalog/biznis/oglasi')->with(
            'status',
            $ad->status === ContentStatus::Poslano ? 'Oglas je poslan na odobrenje.' : 'Oglas je sačuvan kao nacrt.'
        );
    }

    protected function vrste(): array
    {
        return Category::where('type', 'oglasi')
            ->orderBy('label')
            ->get()
            ->map(fn (Category $c) => ['value' => $c->id, 'label' => $c->label])
            ->all();
    }

    protected function authorizeOwner(Ad $ad): void
    {
        abort_unless($ad->user_id === auth()->id(), 403);
    }
}
