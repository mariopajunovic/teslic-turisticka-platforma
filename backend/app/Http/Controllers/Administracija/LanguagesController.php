<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use App\Providers\LocaleConfigServiceProvider;
use App\Support\Translations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class LanguagesController extends Controller
{
    public function index(): Response
    {
        $languages = Locale::orderBy('sort_order')->orderBy('id')->get()
            ->map(fn (Locale $l) => $this->row($l))
            ->all();

        return Inertia::render('Languages', [
            'languages' => $languages,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'min:2', 'max:8', 'regex:/^[a-z]{2,8}$/', Rule::unique('locales', 'code')],
            'name' => ['required', 'string', 'max:60'],
        ]);

        $locale = Locale::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'is_system' => false,
            'is_active' => true,
            'sort_order' => (int) Locale::max('sort_order') + 1,
        ]);

        $this->invalidate();
        $this->log($request, 'created', ['jezik' => $locale->name, 'kod' => $locale->code], [], 'Dodan jezik '.$locale->name);

        return back(303)->with('status', 'Jezik „'.$locale->name.'" je dodan.');
    }

    public function update(Request $request, Locale $locale): RedirectResponse
    {
        if ($locale->is_system) {
            return back(303)->with('error', 'Sistemski jezik se ne može mijenjati.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'is_active' => ['required', 'boolean'],
        ]);

        $old = ['jezik' => $locale->name, 'status' => $locale->is_active ? 'Aktivan' : 'Neaktivan'];

        $locale->update(['name' => $data['name'], 'is_active' => $data['is_active']]);

        $this->invalidate();
        $this->log(
            $request,
            'updated',
            ['jezik' => $locale->name, 'status' => $locale->is_active ? 'Aktivan' : 'Neaktivan'],
            $old,
            'Izmijenjen jezik '.$locale->name,
        );

        return back(303)->with('status', 'Jezik je ažuriran.');
    }

    public function destroy(Request $request, Locale $locale): RedirectResponse
    {
        if ($locale->is_system) {
            return back(303)->with('error', 'Sistemski jezik se ne može obrisati.');
        }

        $name = $locale->name;
        $locale->delete();

        $this->invalidate();
        $this->log($request, 'deleted', [], ['jezik' => $name], 'Obrisan jezik '.$name);

        return back(303)->with('status', 'Jezik „'.$name.'" je obrisan.');
    }

    protected function row(Locale $locale): array
    {
        return [
            'id' => $locale->id,
            'code' => $locale->code,
            'name' => $locale->name,
            'isSystem' => (bool) $locale->is_system,
            'isActive' => (bool) $locale->is_active,
            'bothScripts' => $locale->code === 'sr',
        ];
    }

    protected function invalidate(): void
    {
        Cache::forget(LocaleConfigServiceProvider::CACHE_KEY);
        app(Translations::class)->forget();

        try {
            if (app()->routesAreCached()) {
                Artisan::call('route:clear');
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }

    protected function log(Request $request, string $event, array $attributes, array $old, string $opis): void
    {
        $props = ['ip' => $request->ip(), 'user_agent' => $request->userAgent()];

        if ($attributes) {
            $props['attributes'] = $attributes;
        }

        if ($old) {
            $props['old'] = $old;
        }

        activity('sistem')
            ->causedBy(auth('admin')->user())
            ->event($event)
            ->withProperties($props)
            ->log($opis);
    }
}
