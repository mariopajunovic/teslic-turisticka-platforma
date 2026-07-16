<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class LozinkaController extends Controller
{
    public function zaboravljena(): Response
    {
        return Inertia::render('ZaboravljenaLozinka');
    }

    public function posalji(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']], [
            'email.required' => 'Unesite e-mail adresu.',
            'email.email' => 'Unesite ispravnu e-mail adresu.',
        ]);

        Password::broker('admins')->sendResetLink(['email' => mb_strtolower(trim($request->input('email')))]);

        return back()->with('status', 'Ako nalog s tom adresom postoji, poslali smo link za reset lozinke.');
    }

    public function show(Request $request, string $token): Response
    {
        return Inertia::render('PostaviLozinku', [
            'token' => $token,
            'email' => (string) $request->query('email', ''),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ], [
            'password.confirmed' => 'Lozinke se ne podudaraju.',
            'password.min' => 'Lozinka mora imati najmanje 8 znakova.',
        ]);

        $status = Password::broker('admins')->reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $data['token'],
            ],
            function ($admin, $password) {
                $admin->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('administracija.prijava.show')
                ->with('status', 'Lozinka je postavljena. Sada se možete prijaviti.');
        }

        throw ValidationException::withMessages([
            'password' => 'Link je nevažeći ili je istekao. Zatražite novi.',
        ]);
    }
}
