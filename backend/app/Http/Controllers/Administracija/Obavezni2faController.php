<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Administracija\Concerns\ManagesTwoFactorSetup;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class Obavezni2faController extends Controller
{
    use ManagesTwoFactorSetup;

    public function show(): Response|RedirectResponse
    {
        $admin = auth('admin')->user();

        if ($admin->getAppAuthenticationSecret()) {
            return redirect()->route('administracija.dashboard');
        }

        return Inertia::render('PostaviDvofaktorsku', $this->setupPayload($admin));
    }

    public function store(Request $request): Response|RedirectResponse
    {
        $request->validate(['code' => ['required', 'string']], [
            'code.required' => 'Unesite kod iz aplikacije.',
        ]);

        $admin = auth('admin')->user();
        $codes = $this->aktiviraj2fa($admin, $request->input('code'));

        if ($codes === null) {
            throw ValidationException::withMessages(['code' => 'Kod nije ispravan. Pokušajte ponovo.']);
        }

        return Inertia::render('RezervniKodovi', ['kodovi' => $codes]);
    }
}
