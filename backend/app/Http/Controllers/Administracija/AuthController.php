<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    public function showPrijava(Request $request): Response
    {
        return Inertia::render('Prijava', [
            'status' => $request->session()->get('status'),
        ]);
    }

    public function prijava(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        $key = 'administracija-prijava:'.Str::lower($data['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Previše pokušaja prijave. Pokušajte ponovo za '.RateLimiter::availableIn($key).' sekundi.',
            ]);
        }

        $admin = Auth::guard('admin')->getProvider()->retrieveByCredentials([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (! $admin || ! Auth::guard('admin')->getProvider()->validateCredentials($admin, ['password' => $data['password']])) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages([
                'email' => 'Podaci za prijavu nisu ispravni.',
            ]);
        }

        RateLimiter::clear($key);

        if (! $admin->aktivan) {
            throw ValidationException::withMessages([
                'email' => 'Nalog je deaktiviran. Obratite se drugom administratoru.',
            ]);
        }

        if ($admin->getAppAuthenticationSecret()) {
            $request->session()->put('administracija.2fa.id', $admin->getKey());
            $request->session()->put('administracija.2fa.remember', (bool) ($data['remember'] ?? false));

            return redirect()->route('administracija.2fa.show');
        }

        Auth::guard('admin')->login($admin, (bool) ($data['remember'] ?? false));
        $request->session()->regenerate();

        return redirect()->intended(route('administracija.dashboard'));
    }

    public function show2fa(Request $request): Response|RedirectResponse
    {
        if (! $request->session()->has('administracija.2fa.id')) {
            return redirect()->route('administracija.prijava.show');
        }

        return Inertia::render('Dvofaktorska');
    }

    public function verify2fa(Request $request): RedirectResponse
    {
        $id = $request->session()->get('administracija.2fa.id');

        if (! $id) {
            return redirect()->route('administracija.prijava.show');
        }

        $data = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $admin = Auth::guard('admin')->getProvider()->retrieveById($id);

        if (! $admin) {
            $request->session()->forget(['administracija.2fa.id', 'administracija.2fa.remember']);

            throw ValidationException::withMessages([
                'code' => 'Sesija je istekla. Prijavite se ponovo.',
            ]);
        }

        if (! $this->verifyCode($admin, $data['code'])) {
            throw ValidationException::withMessages([
                'code' => 'Kod nije ispravan.',
            ]);
        }

        $remember = (bool) $request->session()->get('administracija.2fa.remember', false);
        $request->session()->forget(['administracija.2fa.id', 'administracija.2fa.remember']);

        Auth::guard('admin')->login($admin, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('administracija.dashboard'));
    }

    public function odjava(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('administracija.prijava.show');
    }

    protected function verifyCode($admin, string $code): bool
    {
        $code = trim($code);
        $secret = $admin->getAppAuthenticationSecret();

        if ($secret && (new Google2FA)->verifyKey($secret, preg_replace('/\s+/', '', $code))) {
            return true;
        }

        $recovery = $admin->getAppAuthenticationRecoveryCodes() ?? [];

        if (in_array($code, $recovery, true)) {
            $admin->saveAppAuthenticationRecoveryCodes(array_values(array_diff($recovery, [$code])));

            return true;
        }

        return false;
    }
}
