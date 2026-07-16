<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administracija\StoreUlogaRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Inertia\Response;

class UlogeController extends Controller
{
    protected array $redoslijed = [
        'upravljanje sadržajem',
        'upravljanje korisnicima',
        'upravljanje stranicama',
        'sistemske postavke',
        'pregled logova',
    ];

    protected array $zasticene = ['administrator'];

    public function index(): Response
    {
        $roles = Role::where('guard_name', 'admin')->with('permissions')->withCount('users')->get();
        $permisije = $this->permisije();
        $boje = ['ok', 'warn', 'bad', 'gray', 'brand', 'info'];

        $uloge = $roles->values()->map(fn (Role $r, $i) => [
            'id' => $r->id,
            'naziv' => Str::ucfirst($r->name),
            'kljuc' => $r->name,
            'opis' => $r->opis ?: 'Bez opisa.',
            'boja' => match ($r->name) {
                'administrator' => 'brand',
                'urednik' => 'info',
                default => $boje[$i % count($boje)],
            },
            'brojNaloga' => $r->users_count,
            'zasticena' => in_array($r->name, $this->zasticene),
            'dozvole' => $r->permissions->pluck('name')->all(),
        ])->all();

        $matrica = $permisije->map(fn (Permission $p) => [
            'kljuc' => $p->name,
            'dozvola' => Str::ucfirst($p->name),
            'uloge' => $roles->mapWithKeys(fn (Role $r) => [$r->id => $r->hasPermissionTo($p)])->all(),
        ])->all();

        $kolone = $roles->map(fn (Role $r) => [
            'id' => $r->id,
            'naziv' => Str::ucfirst($r->name),
            'zasticena' => in_array($r->name, $this->zasticene),
        ])->all();

        return Inertia::render('Uloge', [
            'uloge' => $uloge,
            'matrica' => $matrica,
            'kolone' => $kolone,
            'sveDozvole' => $permisije->map(fn (Permission $p) => [
                'kljuc' => $p->name,
                'labela' => Str::ucfirst($p->name),
            ])->all(),
        ]);
    }

    public function store(StoreUlogaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $kljuc = Str::lower(trim($data['naziv']));
        $dozvole = $this->validneDozvole($data['dozvole'] ?? []);

        $role = Role::create(['name' => $kljuc, 'guard_name' => 'admin']);
        $role->opis = $data['opis'] ?? null;
        $role->save();
        $role->syncPermissions($dozvole);

        $this->logujUlogu($role, 'created', [
            'naziv' => Str::ucfirst($kljuc),
            'opis' => $role->opis ?: '(bez opisa)',
            'dozvole' => $this->labele($dozvole) ?: '(nema)',
        ], [], 'Kreirana uloga '.Str::ucfirst($kljuc));

        return back()->with('status', 'Uloga „'.Str::ucfirst($kljuc).'" je kreirana.');
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'dodjele' => ['array'],
            'dodjele.*' => ['array'],
            'dodjele.*.*' => ['string', Rule::exists('permissions', 'name')->where('guard_name', 'admin')],
        ], [
            'dodjele.*.*.exists' => 'Odabrana dozvola nije važeća.',
        ]);

        foreach ($data['dodjele'] ?? [] as $roleId => $dozvole) {
            $role = Role::where('guard_name', 'admin')->find($roleId);

            if (! $role || in_array($role->name, $this->zasticene)) {
                continue;
            }

            $stare = $role->permissions->pluck('name')->sort()->values()->all();
            $nove = $this->validneDozvole((array) $dozvole);
            sort($nove);

            if ($stare === $nove) {
                continue;
            }

            $role->syncPermissions($nove);

            $this->logujUlogu($role, 'updated', [
                'dozvole' => $this->labele($nove) ?: '(nema)',
            ], [
                'dozvole' => $this->labele($stare) ?: '(nema)',
            ], 'Izmijenjene dozvole uloge '.Str::ucfirst($role->name));
        }

        return back()->with('status', 'Dozvole su sačuvane.');
    }

    public function destroy(Role $uloga): RedirectResponse
    {
        if (in_array($uloga->name, $this->zasticene)) {
            return back()->with('error', 'Osnovna uloga se ne može obrisati.');
        }

        $this->logujUlogu($uloga, 'deleted', [], [
            'naziv' => Str::ucfirst($uloga->name),
            'dozvole' => $this->labele($uloga->permissions->pluck('name')->all()) ?: '(nema)',
        ], 'Obrisana uloga '.Str::ucfirst($uloga->name));

        $uloga->delete();

        return back()->with('status', 'Uloga je obrisana.');
    }

    protected function logujUlogu(Role $role, string $event, array $attributes, array $old, string $opis): void
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
            ->performedOn($role)
            ->causedBy(auth('admin')->user() ?? auth('web')->user())
            ->event($event)
            ->withProperties($props)
            ->log($opis);
    }

    protected function labele(array $imena): string
    {
        return collect($imena)->map(fn ($n) => Str::ucfirst($n))->implode(', ');
    }

    public function korisnici(Role $uloga): JsonResponse
    {
        $korisnici = Admin::role($uloga->name, 'admin')->orderBy('name')->get()->map(fn (Admin $a) => [
            'ime' => $a->name,
            'email' => $a->email,
            'initials' => $this->initials($a->name),
        ])->all();

        return response()->json([
            'naziv' => Str::ucfirst($uloga->name),
            'korisnici' => $korisnici,
        ]);
    }

    protected function permisije()
    {
        return Permission::where('guard_name', 'admin')->get()
            ->sortBy(function (Permission $p) {
                $i = array_search($p->name, $this->redoslijed);

                return $i === false ? 999 : $i;
            })
            ->values();
    }

    protected function validneDozvole(array $imena): array
    {
        $dostupne = Permission::where('guard_name', 'admin')->pluck('name')->all();

        return array_values(array_intersect($imena, $dostupne));
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
