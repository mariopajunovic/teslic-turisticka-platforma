<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administracija\StoreAdministratorRequest;
use App\Http\Requests\Administracija\UpdateAdministratorRequest;
use App\Models\Admin;
use App\Notifications\AdminLozinkaLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Inertia\Response;

class AdministratoriController extends Controller
{
    public function index(): Response
    {
        $query = Admin::with('roles')->orderByDesc('is_super')->orderBy('name');

        if (! auth('admin')->user()->is_super) {
            $query->where('is_super', false);
        }

        $administratori = $query->get()
            ->map(fn (Admin $admin) => $this->row($admin))
            ->all();

        $uloge = Role::where('guard_name', 'admin')->orderBy('name')->get()
            ->map(fn (Role $r) => ['value' => $r->name, 'label' => Str::ucfirst($r->name)])
            ->all();

        return Inertia::render('Administratori', [
            'administratori' => $administratori,
            'uloge' => $uloge,
        ]);
    }

    public function store(StoreAdministratorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $admin = new Admin();
        $admin->name = $data['ime'];
        $admin->email = $data['email'];
        $admin->password = Hash::make(Str::random(40));
        $admin->is_super = false;
        $admin->aktivan = true;
        $admin->save();
        $admin->assignRole($data['uloga']);

        $token = Password::broker('admins')->getRepository()->create($admin);
        $admin->notify(new AdminLozinkaLink($token, true));

        $this->log($admin, 'created', [
            'ime' => $admin->name,
            'email' => $admin->email,
            'uloga' => Str::ucfirst($data['uloga']),
        ], [], 'Kreiran administrator '.$admin->name);

        return back()->with('status', 'Administrator je kreiran. Poslan je email s linkom za postavljanje lozinke.');
    }

    public function update(UpdateAdministratorRequest $request, Admin $administrator): RedirectResponse
    {
        if ($zabrana = $this->zastita($administrator)) {
            return $zabrana;
        }

        $data = $request->validated();

        $staro = [
            'ime' => $administrator->name,
            'email' => $administrator->email,
            'uloga' => Str::ucfirst($administrator->getRoleNames()->first() ?? '-'),
        ];

        $administrator->name = $data['ime'];
        $administrator->email = $data['email'];
        $administrator->save();

        if (! $administrator->is_super && array_key_exists('uloga', $data)) {
            $administrator->syncRoles(array_filter([$data['uloga']]));
        }

        $novo = [
            'ime' => $administrator->name,
            'email' => $administrator->email,
            'uloga' => Str::ucfirst($administrator->getRoleNames()->first() ?? '-'),
        ];

        $izmjene = array_keys(array_diff_assoc($novo, $staro));

        if ($izmjene) {
            $this->log(
                $administrator,
                'updated',
                array_intersect_key($novo, array_flip($izmjene)),
                array_intersect_key($staro, array_flip($izmjene)),
                'Izmijenjen administrator '.$administrator->name,
            );
        }

        return back()->with('status', 'Administrator je ažuriran.');
    }

    public function resetLozinke(Admin $administrator): RedirectResponse
    {
        if ($zabrana = $this->zastita($administrator)) {
            return $zabrana;
        }

        Password::broker('admins')->sendResetLink(['email' => $administrator->email]);

        $this->log($administrator, 'updated', ['radnja' => 'Poslan link za reset lozinke'], [], 'Reset lozinke: '.$administrator->name);

        return back()->with('status', 'Link za reset lozinke je poslan na '.$administrator->email.'.');
    }

    public function reset2fa(Admin $administrator): RedirectResponse
    {
        if ($zabrana = $this->zastita($administrator)) {
            return $zabrana;
        }

        $administrator->saveAppAuthenticationSecret(null);
        $administrator->saveAppAuthenticationRecoveryCodes(null);

        $this->log($administrator, 'updated', ['2FA' => 'Onemogućen'], ['2FA' => 'Aktivan'], '2FA onemogućen za '.$administrator->name);

        return back()->with('status', '2FA je onemogućen za '.$administrator->name.'. Pri sljedećoj prijavi može ga ponovo postaviti.');
    }

    public function deaktiviraj(Admin $administrator): RedirectResponse
    {
        if ($administrator->is_super) {
            return back()->with('error', 'Super administrator se ne može deaktivirati.');
        }

        if ($administrator->id === auth('admin')->id()) {
            return back()->with('error', 'Ne možete deaktivirati vlastiti nalog.');
        }

        $administrator->update(['aktivan' => false]);

        $this->log($administrator, 'updated', ['status' => 'Neaktivan'], ['status' => 'Aktivan'], 'Deaktiviran administrator '.$administrator->name);

        return back()->with('status', 'Administrator je deaktiviran.');
    }

    public function aktiviraj(Admin $administrator): RedirectResponse
    {
        $administrator->update(['aktivan' => true]);

        $this->log($administrator, 'updated', ['status' => 'Aktivan'], ['status' => 'Neaktivan'], 'Aktiviran administrator '.$administrator->name);

        return back()->with('status', 'Administrator je aktiviran.');
    }

    protected function row(Admin $admin): array
    {
        $dvaFA = (bool) $admin->getAppAuthenticationSecret();
        $role = $admin->getRoleNames()->first();

        if ($admin->is_super) {
            $uloga = 'Super administrator';
            $ulogaBoja = 'bad';
        } else {
            $uloga = $role ? Str::ucfirst($role) : '-';
            $ulogaBoja = $role === 'urednik' ? 'info' : 'brand';
        }

        return [
            'id' => $admin->id,
            'ime' => $admin->name,
            'email' => $admin->email,
            'initials' => $this->initials($admin->name),
            'uloga' => $uloga,
            'ulogaBoja' => $ulogaBoja,
            'ulogaKljuc' => $role,
            'dvaFA' => $dvaFA,
            'dvaFAtekst' => $dvaFA ? 'Aktivno' : 'Nije postavljeno',
            'zadnjaPrijava' => $admin->last_login_at ? Carbon::parse($admin->last_login_at)->diffForHumans() : 'Nikad',
            'aktivan' => (bool) $admin->aktivan,
            'jeSuper' => (bool) $admin->is_super,
            'jaSam' => $admin->id === auth('admin')->id(),
        ];
    }

    protected function zastita(Admin $administrator): ?RedirectResponse
    {
        if ($administrator->is_super) {
            return back()->with('error', 'Super administrator se ne može mijenjati odavde.');
        }

        if ($administrator->id === auth('admin')->id()) {
            return back()->with('error', 'Svoj nalog uređujete preko „Moj profil".');
        }

        return null;
    }

    protected function log(Admin $admin, string $event, array $attributes, array $old, string $opis): void
    {
        $props = [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        if ($attributes) {
            $props['attributes'] = $attributes;
        }

        if ($old) {
            $props['old'] = $old;
        }

        activity('sistem')
            ->performedOn($admin)
            ->causedBy(auth('admin')->user())
            ->event($event)
            ->withProperties($props)
            ->log($opis);
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
