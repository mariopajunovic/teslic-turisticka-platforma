<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class KorisniciController extends Controller
{
    public function index(Request $request): Response
    {
        $status = $request->query('status');
        $uloga = $request->query('uloga');
        $q = $request->query('q');

        $korisnici = User::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($uloga, fn ($query) => $query->where('role', $uloga))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', '%'.$q.'%')
                        ->orWhere('email', 'like', '%'.$q.'%');
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString()
            ->through(fn (User $user) => $this->row($user));

        return Inertia::render('Korisnici', [
            'korisnici' => $korisnici,
            'filteri' => [
                'status' => $status,
                'uloga' => $uloga,
                'q' => $q,
            ],
        ]);
    }

    public function odobri(User $korisnik): RedirectResponse
    {
        $korisnik->update(['status' => 'aktivan']);

        return back()->with('status', 'Korisnik je odobren.');
    }

    public function blokiraj(User $korisnik): RedirectResponse
    {
        $korisnik->update(['status' => 'blokiran']);

        return back()->with('status', 'Korisnik je blokiran.');
    }

    public function odblokiraj(User $korisnik): RedirectResponse
    {
        $korisnik->update(['status' => 'aktivan']);

        return back()->with('status', 'Korisnik je odblokiran.');
    }

    protected function row(User $user): array
    {
        $role = $user->role?->value;

        return [
            'id' => $user->id,
            'ime' => $user->name,
            'email' => $user->email,
            'initials' => $this->initials($user->name),
            'uloga' => $user->role?->getLabel() ?? '-',
            'ulogaBoja' => $role === 'autor' ? 'info' : 'brand',
            'status' => $user->status,
            'statusBoja' => match ($user->status) {
                'aktivan' => 'ok',
                'blokiran' => 'bad',
                default => 'warn',
            },
            'zadnjaPrijava' => $user->last_login_at ? Carbon::parse($user->last_login_at)->diffForHumans() : 'Nikad',
            'akcija' => match ($user->status) {
                'na_odobrenju' => 'odobri',
                'blokiran' => 'odblokiraj',
                default => 'blokiraj',
            },
        ];
    }

    protected function initials(?string $name): string
    {
        $name = trim((string) $name);

        if ($name === '') {
            return '?';
        }

        $parts = preg_split('/\s+/', $name);
        $first = Str::substr($parts[0], 0, 1);
        $last = count($parts) > 1 ? Str::substr($parts[count($parts) - 1], 0, 1) : '';

        return Str::upper($first.$last);
    }
}
