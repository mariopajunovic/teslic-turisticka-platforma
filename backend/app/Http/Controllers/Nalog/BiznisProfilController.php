<?php

namespace App\Http\Controllers\Nalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BiznisProfilRequest;
use Illuminate\Http\RedirectResponse;
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

    public function update(BiznisProfilRequest $request): RedirectResponse
    {
        $data = $request->validated();

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
