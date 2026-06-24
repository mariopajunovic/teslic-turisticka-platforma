<?php

namespace App\Http\Controllers\Nalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BiznisProfilController extends Controller
{
    public function edit(): Response
    {
        $user = auth()->user();

        return Inertia::render('account/BiznisProfil', [
            'profil' => [
                'name' => $user->name,
                'email' => $user->email,
                'telefon' => $user->telefon,
                'bio' => $user->bio,
                'avatar' => $user->getFirstMediaUrl('avatar'),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:4096'],
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $data['name'],
            'telefon' => $data['telefon'] ?? null,
            'bio' => $data['bio'] ?? null,
        ]);

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        return redirect('/nalog/biznis/profil')->with('status', 'Profil naloga je sačuvan.');
    }
}
