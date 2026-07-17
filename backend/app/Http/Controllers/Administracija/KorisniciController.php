<?php

namespace App\Http\Controllers\Administracija;

use App\Enums\ContentStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Business;
use App\Models\News;
use App\Models\Story;
use App\Models\User;
use App\Notifications\KorisnikLozinkaLink;
use App\Support\ActivityPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Activitylog\Models\Activity;

class KorisniciController extends Controller
{
    protected const STATUSI = ['na_odobrenju', 'aktivan', 'blokiran'];

    public function index(Request $request): Response
    {
        $status = $request->query('status');
        $uloga = $request->query('uloga');
        $q = $request->query('q');

        $obrisani = $status === 'obrisani';

        $korisnici = User::query()
            ->with('media')
            ->when($obrisani, fn ($query) => $query->onlyTrashed())
            ->when(! $obrisani && $status, fn ($query) => $query->where('status', $status))
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

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ime' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'uloga' => ['required', Rule::enum(UserRole::class)],
            'status' => ['required', Rule::in(self::STATUSI)],
            'telefon' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'array'],
            'bio.*' => ['nullable', 'string'],
            'posalji_email' => ['nullable', 'boolean'],
        ]);

        $korisnik = new User();
        $korisnik->name = $data['ime'];
        $korisnik->email = $data['email'];
        $korisnik->password = Hash::make(Str::random(40));
        $korisnik->role = $data['uloga'];
        $korisnik->status = $data['status'];
        $korisnik->telefon = $data['telefon'] ?? null;
        $korisnik->setTranslations('bio', array_filter($data['bio'] ?? [], fn ($v) => trim((string) $v) !== ''));
        $korisnik->save();

        if ($request->boolean('posalji_email', true)) {
            $this->posaljiLozinkuLink($korisnik);

            return back()->with('status', 'Korisnik je kreiran. Poslan je email s linkom za postavljanje lozinke.');
        }

        return back()->with('status', 'Korisnik je kreiran. Email za postavljanje lozinke možete poslati kasnije iz menija.');
    }

    public function show(Request $request, User $korisnik): Response
    {
        $stranica = fn (string $key) => max(1, (int) $request->query($key.'_page', 1));

        $sekcije = match ($korisnik->role) {
            UserRole::Biznis => [
                $this->section('biznisi', 'Biznisi', Business::class, $korisnik->id, $stranica('biznisi')),
                $this->section('oglasi', 'Oglasi', Ad::class, $korisnik->id, $stranica('oglasi')),
                $this->section('objave', 'Objave', News::class, $korisnik->id, $stranica('objave')),
            ],
            UserRole::Autor => [
                $this->section('price', 'Priče', Story::class, $korisnik->id, $stranica('price')),
            ],
            default => [],
        };

        return Inertia::render('Korisnici/Detalji', [
            'korisnik' => $this->detail($korisnik),
            'sekcije' => $sekcije,
            'logovi' => $this->logs($korisnik, $stranica('log')),
        ]);
    }

    public function update(Request $request, User $korisnik): RedirectResponse
    {
        $data = $request->validate([
            'ime' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($korisnik->id)],
            'uloga' => ['required', Rule::enum(UserRole::class)],
            'status' => ['required', Rule::in(self::STATUSI)],
            'telefon' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'array'],
            'bio.*' => ['nullable', 'string'],
        ]);

        if ($korisnik->email !== $data['email']) {
            $korisnik->email_verified_at = null;
        }

        $korisnik->name = $data['ime'];
        $korisnik->email = $data['email'];
        $korisnik->role = $data['uloga'];
        $korisnik->status = $data['status'];
        $korisnik->telefon = $data['telefon'] ?? null;
        $korisnik->setTranslations('bio', array_filter($data['bio'] ?? [], fn ($v) => trim((string) $v) !== ''));
        $korisnik->save();

        return back()->with('status', 'Korisnik je ažuriran.');
    }

    public function resetLozinke(User $korisnik): RedirectResponse
    {
        $noviNalog = $this->posaljiLozinkuLink($korisnik);

        return back()->with('status', $noviNalog
            ? 'Poslan je email s linkom za postavljanje lozinke na '.$korisnik->email.'.'
            : 'Link za reset lozinke je poslan na '.$korisnik->email.'.');
    }

    protected function posaljiLozinkuLink(User $korisnik): bool
    {
        $noviNalog = $korisnik->last_login_at === null;

        $token = Password::broker('users')->getRepository()->create($korisnik);
        $korisnik->notify(new KorisnikLozinkaLink($token, noviNalog: $noviNalog));

        return $noviNalog;
    }

    public function destroy(User $korisnik): RedirectResponse
    {
        $ime = $korisnik->name;

        $korisnik->delete();

        return redirect('/administracija/korisnici')->with('status', 'Korisnik „'.$ime.'" je obrisan. Možete ga vratiti iz kartice „Obrisani".');
    }

    public function avatar(Request $request, User $korisnik): RedirectResponse
    {
        $request->validate(['image' => ['required', 'image', 'max:5120']]);

        $korisnik->clearMediaCollection('avatar');
        $korisnik->addMediaFromRequest('image')->toMediaCollection('avatar');

        return back()->with('status', 'Avatar je sačuvan.');
    }

    public function obrisiAvatar(User $korisnik): RedirectResponse
    {
        $korisnik->clearMediaCollection('avatar');

        return back()->with('status', 'Avatar je uklonjen.');
    }

    public function vrati(User $korisnik): RedirectResponse
    {
        $korisnik->restore();

        return back()->with('status', 'Korisnik „'.$korisnik->name.'" je vraćen.');
    }

    public function trajnoObrisi(User $korisnik): RedirectResponse
    {
        $ime = $korisnik->name;

        $korisnik->forceDelete();

        return back()->with('status', 'Korisnik „'.$ime.'" je trajno obrisan.');
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

    protected function detail(User $user): array
    {
        return [
            'id' => $user->id,
            'ime' => $user->name,
            'email' => $user->email,
            'initials' => $this->initials($user->name),
            'avatar' => $user->getFirstMediaUrl('avatar') ?: null,
            'uloga' => $user->role?->getLabel() ?? '-',
            'ulogaKljuc' => $user->role?->value,
            'ulogaBoja' => $user->role === UserRole::Autor ? 'brand' : 'info',
            'status' => $user->status,
            'statusLabel' => $this->statusLabel($user->status),
            'statusBoja' => $this->statusBoja($user->status),
            'telefon' => $user->telefon,
            'bio' => $user->bio,
            'bioTranslations' => $user->getTranslations('bio'),
            'registrovan' => $user->created_at?->format('d.m.Y.'),
            'zadnjaPrijava' => $user->last_login_at ? Carbon::parse($user->last_login_at)->diffForHumans() : 'Nikad',
            'emailVerifikovan' => (bool) $user->email_verified_at,
        ];
    }

    protected function section(string $key, string $naslov, string $model, int $userId, int $page): array
    {
        $per = 5;
        $query = $model::query()->where('user_id', $userId);
        $total = (clone $query)->count();
        $lastPage = max(1, (int) ceil($total / $per));
        $page = min($page, $lastPage);

        $items = $query->latest()->forPage($page, $per)->get()
            ->map(function (Model $m) {
                $status = $m->status instanceof ContentStatus ? $m->status : ContentStatus::tryFrom((string) $m->status);

                return [
                    'id' => $m->id,
                    'naslov' => $m->naslov ?? '-',
                    'status' => $status?->getLabel() ?? '-',
                    'statusBoja' => $this->contentBoja($status),
                    'datum' => optional($m->published_at ?? $m->created_at)->format('d.m.Y.'),
                ];
            })
            ->all();

        return [
            'key' => $key,
            'naslov' => $naslov,
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'lastPage' => $lastPage,
        ];
    }

    protected function logs(User $user, int $page): array
    {
        $per = 8;
        $base = Activity::query()
            ->where(function ($q) use ($user) {
                $q->where('causer_type', User::class)->where('causer_id', $user->id);
            })
            ->orWhere(function ($q) use ($user) {
                $q->where('subject_type', User::class)->where('subject_id', $user->id);
            });

        $total = (clone $base)->count();
        $lastPage = max(1, (int) ceil($total / $per));
        $page = min($page, $lastPage);

        $presenter = app(ActivityPresenter::class);

        $items = $base->latest()->forPage($page, $per)->get()
            ->map(fn (Activity $a) => $presenter->present($a))
            ->all();

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'lastPage' => $lastPage,
        ];
    }

    protected function contentBoja(?ContentStatus $status): string
    {
        return match ($status?->getColor()) {
            'success' => 'ok',
            'warning' => 'warn',
            'danger' => 'bad',
            'info' => 'info',
            default => 'gray',
        };
    }

    protected function statusLabel(string $status): string
    {
        return match ($status) {
            'aktivan' => 'Aktivan',
            'blokiran' => 'Blokiran',
            'na_odobrenju' => 'Na odobrenju',
            default => Str::ucfirst($status),
        };
    }

    protected function statusBoja(string $status): string
    {
        return match ($status) {
            'aktivan' => 'ok',
            'blokiran' => 'bad',
            default => 'warn',
        };
    }

    protected function row(User $user): array
    {
        $role = $user->role?->value;

        return [
            'id' => $user->id,
            'ime' => $user->name,
            'email' => $user->email,
            'initials' => $this->initials($user->name),
            'avatar' => $user->getFirstMediaUrl('avatar') ?: null,
            'uloga' => $user->role?->getLabel() ?? '-',
            'ulogaKljuc' => $role,
            'ulogaBoja' => $role === 'autor' ? 'brand' : 'info',
            'status' => $user->status,
            'statusLabel' => $this->statusLabel($user->status),
            'statusBoja' => $this->statusBoja($user->status),
            'emailVerifikovan' => (bool) $user->email_verified_at,
            'telefon' => $user->telefon,
            'bioTranslations' => $user->getTranslations('bio'),
            'zadnjaPrijava' => $user->last_login_at ? Carbon::parse($user->last_login_at)->diffForHumans() : 'Nikad',
            'obrisan' => $user->trashed(),
            'obrisanKad' => $user->deleted_at?->format('d.m.Y.'),
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
