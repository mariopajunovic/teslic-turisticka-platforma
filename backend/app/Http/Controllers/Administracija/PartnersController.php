<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'naziv' => ['required', 'string', 'max:150'],
            'href' => ['nullable', 'url', 'max:255'],
        ]);

        Partner::create([
            'naziv' => $data['naziv'],
            'href' => $data['href'] ?? null,
            'sort_order' => (int) Partner::max('sort_order') + 1,
        ]);

        return back()->with('status', 'Partner je dodan.');
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $data = $request->validate([
            'naziv' => ['required', 'string', 'max:150'],
            'href' => ['nullable', 'url', 'max:255'],
        ]);

        $partner->update([
            'naziv' => $data['naziv'],
            'href' => $data['href'] ?? null,
        ]);

        return back(303)->with('status', 'Partner je ažuriran.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $partner->delete();

        return back()->with('status', 'Partner je uklonjen.');
    }

    public function logo(Request $request, Partner $partner): RedirectResponse
    {
        $request->validate(['image' => ['required', 'image', 'max:4096']]);

        $partner->clearMediaCollection('logo');
        $partner->addMediaFromRequest('image')->toMediaCollection('logo');

        return back()->with('status', 'Logo partnera je sačuvan.');
    }

    public function obrisiLogo(Partner $partner): RedirectResponse
    {
        $partner->clearMediaCollection('logo');

        return back()->with('status', 'Logo partnera je uklonjen.');
    }

    public function redoslijed(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['array'],
            'ids.*' => ['integer'],
        ]);

        foreach ($data['ids'] as $index => $id) {
            Partner::where('id', $id)->update(['sort_order' => $index]);
        }

        return back(303);
    }
}
