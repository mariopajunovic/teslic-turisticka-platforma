<?php

namespace App\Http\Controllers\Nalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\AutorProfilRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AutorProfilController extends Controller
{
    public function edit(): Response
    {
        $user = auth()->user();

        return Inertia::render('account/AutorProfil', [
            'profil' => [
                'name' => $user->name,
                'bio' => $user->bio,
                'avatar' => $user->getFirstMediaUrl('avatar'),
            ],
        ]);
    }

    public function update(AutorProfilRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = auth()->user();
        $user->update(['name' => $data['name'], 'bio' => $data['bio'] ?? null]);

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        return redirect('/nalog/autor/profil')->with('status', 'Autorski profil je sačuvan.');
    }
}
