<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Administracija\Concerns\ManagesTwoFactorSetup;
use App\Http\Controllers\Controller;
use App\Support\TwoFactor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ProfilController extends Controller
{
    use ManagesTwoFactorSetup;

    public function show(): Response
    {
        $admin = auth('admin')->user();
        $dvaFA = (bool) $admin->getAppAuthenticationSecret();

        $props = [
            'admin' => [
                'ime' => $admin->name,
                'email' => $admin->email,
                'initials' => $this->initials($admin->name),
                'uloga' => $admin->is_super ? 'Super administrator' : Str::ucfirst($admin->getRoleNames()->first() ?? '-'),
            ],
            'dvaFA' => $dvaFA,
        ];

        if (! $dvaFA) {
            $props['setup'] = $this->setupPayload($admin);
        }

        return Inertia::render('Profil', $props);
    }

    public function podaci(Request $request): RedirectResponse
    {
        $admin = auth('admin')->user();

        $data = $request->validate([
            'ime' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('admins', 'email')->ignore($admin->id)],
        ], [
            'ime.required' => 'Ime i prezime su obavezni.',
            'email.unique' => 'Ta e-mail adresa je već zauzeta.',
        ]);

        $admin->name = trim($data['ime']);
        $admin->email = mb_strtolower(trim($data['email']));
        $admin->save();

        return back()->with('status', 'Podaci su sačuvani.');
    }

    public function lozinka(Request $request): RedirectResponse
    {
        $admin = auth('admin')->user();

        $data = $request->validate([
            'trenutna' => ['required', 'string'],
            'lozinka' => ['required', 'confirmed', PasswordRule::min(8)],
        ], [
            'trenutna.required' => 'Unesite trenutnu lozinku.',
            'lozinka.confirmed' => 'Lozinke se ne podudaraju.',
            'lozinka.min' => 'Lozinka mora imati najmanje 8 znakova.',
        ]);

        if (! Hash::check($data['trenutna'], $admin->password)) {
            throw ValidationException::withMessages(['trenutna' => 'Trenutna lozinka nije ispravna.']);
        }

        $admin->forceFill(['password' => Hash::make($data['lozinka'])])->save();

        return back()->with('status', 'Lozinka je promijenjena.');
    }

    public function omoguci2fa(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string']], [
            'code.required' => 'Unesite kod iz aplikacije.',
        ]);

        $admin = auth('admin')->user();
        $codes = $this->aktiviraj2fa($admin, $request->input('code'));

        if ($codes === null) {
            throw ValidationException::withMessages(['code' => 'Kod nije ispravan. Pokušajte ponovo.']);
        }

        return back()
            ->with('status', 'Dvofaktorska zaštita je aktivirana.')
            ->with('recoveryCodes', $codes);
    }

    public function regenerisi(Request $request): RedirectResponse
    {
        $request->validate(['trenutna' => ['required', 'string']], [
            'trenutna.required' => 'Unesite lozinku za potvrdu.',
        ]);

        $admin = auth('admin')->user();

        if (! Hash::check($request->input('trenutna'), $admin->password)) {
            throw ValidationException::withMessages(['trenutna' => 'Lozinka nije ispravna.']);
        }

        if (! $admin->getAppAuthenticationSecret()) {
            return back()->with('error', 'Dvofaktorska zaštita nije aktivna.');
        }

        $codes = app(TwoFactor::class)->recoveryCodes();
        $admin->saveAppAuthenticationRecoveryCodes($codes);

        return back()
            ->with('status', 'Rezervni kodovi su regenerisani.')
            ->with('recoveryCodes', $codes);
    }

    public function onemoguci2fa(Request $request): RedirectResponse
    {
        $request->validate(['trenutna' => ['required', 'string']], [
            'trenutna.required' => 'Unesite lozinku za potvrdu.',
        ]);

        $admin = auth('admin')->user();

        if (! Hash::check($request->input('trenutna'), $admin->password)) {
            throw ValidationException::withMessages(['trenutna' => 'Lozinka nije ispravna.']);
        }

        $admin->saveAppAuthenticationSecret(null);
        $admin->saveAppAuthenticationRecoveryCodes(null);

        return back()->with('status', 'Dvofaktorska zaštita je isključena.');
    }

    protected function initials(?string $name): string
    {
        $name = trim((string) $name);

        if ($name === '') {
            return '?';
        }

        $p = preg_split('/\s+/', $name);

        return Str::upper(Str::substr($p[0], 0, 1).(count($p) > 1 ? Str::substr($p[count($p) - 1], 0, 1) : ''));
    }
}
