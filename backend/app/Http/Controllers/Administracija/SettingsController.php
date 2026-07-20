<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Settings\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(): Response
    {
        $s = app(SiteSettings::class);

        return Inertia::render('Postavke', [
            'postavke' => [
                'brand_naziv' => $s->brand_naziv,
                'brand_logo_tekst' => $s->brand_logo_tekst,
                'brand_logo' => $s->brand_logo ? Storage::disk('public')->url($s->brand_logo) : null,
                'logo_visina' => $s->logo_visina,
                'seo_opis' => $s->seo_opis,
                'kontakt_adresa' => $s->kontakt_adresa,
                'kontakt_telefon' => $s->kontakt_telefon,
                'kontakt_email' => $s->kontakt_email,
                'footer_opis' => $s->footer_opis,
                'copyright' => $s->copyright,
                'partneri_tekst' => $s->partneri_tekst,
                'social' => array_values($s->social),
                'google_indeksiranje' => $s->google_indeksiranje,
                'odrzavanje' => $s->odrzavanje,
                'odrzavanje_lozinka' => $s->odrzavanje_lozinka,
                'odrzavanje_minuta' => $s->odrzavanje_minuta,
                'odrzavanje_poruka' => $s->odrzavanje_poruka,
                'captcha_site_key' => $s->captcha_site_key,
                'captcha_secret_set' => filled($s->captcha_secret),
            ],
            'partneri' => Partner::orderBy('sort_order')->orderBy('id')->get()->map(fn (Partner $p) => [
                'id' => $p->id,
                'naziv' => $p->naziv,
                'href' => $p->href,
                'logo' => $p->logoUrl(),
            ])->all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'brand_naziv' => ['required', 'array'],
            'brand_naziv.sr' => ['required', 'string', 'max:255'],
            'brand_naziv.*' => ['nullable', 'string', 'max:255'],
            'brand_logo_tekst' => ['required', 'array'],
            'brand_logo_tekst.sr' => ['required', 'string', 'max:255'],
            'brand_logo_tekst.*' => ['nullable', 'string', 'max:255'],
            'kontakt_adresa' => ['required', 'string', 'max:255'],
            'kontakt_telefon' => ['required', 'string', 'max:255'],
            'kontakt_email' => ['required', 'email', 'max:255'],
            'footer_opis' => ['array'],
            'footer_opis.*' => ['nullable', 'string', 'max:2000'],
            'copyright' => ['array'],
            'copyright.*' => ['nullable', 'string', 'max:500'],
            'partneri_tekst' => ['array'],
            'partneri_tekst.*' => ['nullable', 'string', 'max:600'],
            'logo_visina' => ['required', 'integer', 'min:12', 'max:200'],
            'seo_opis' => ['array'],
            'seo_opis.*' => ['nullable', 'string', 'max:300'],
            'social' => ['array'],
            'social.*.name' => ['required', 'string', 'max:50'],
            'social.*.label' => ['nullable', 'string', 'max:100'],
            'social.*.href' => ['nullable', 'url', 'max:255'],
            'google_indeksiranje' => ['boolean'],
            'odrzavanje' => ['boolean'],
            'odrzavanje_lozinka' => ['nullable', 'string', 'max:255'],
            'odrzavanje_minuta' => ['required', 'integer', 'min:1', 'max:10080'],
            'odrzavanje_poruka' => ['nullable', 'string', 'max:1000'],
            'captcha_site_key' => ['nullable', 'string', 'max:255'],
            'captcha_secret' => ['nullable', 'string', 'max:255'],
        ]);

        $s = app(SiteSettings::class);
        $s->brand_naziv = $this->mapa($data['brand_naziv']);
        $s->brand_logo_tekst = $this->mapa($data['brand_logo_tekst']);
        $s->kontakt_adresa = $data['kontakt_adresa'];
        $s->kontakt_telefon = $data['kontakt_telefon'];
        $s->kontakt_email = $data['kontakt_email'];
        $s->footer_opis = $this->mapa($data['footer_opis'] ?? []);
        $s->copyright = $this->mapa($data['copyright'] ?? []);
        $s->partneri_tekst = $this->mapa($data['partneri_tekst'] ?? []);
        $s->logo_visina = (int) $data['logo_visina'];
        $s->seo_opis = $this->mapa($data['seo_opis'] ?? []);
        $s->social = collect($data['social'] ?? [])
            ->map(fn ($x) => [
                'name' => trim($x['name']),
                'label' => trim($x['label'] ?? ''),
                'href' => trim($x['href'] ?? ''),
            ])
            ->values()
            ->all();
        $s->google_indeksiranje = (bool) $data['google_indeksiranje'];
        $s->odrzavanje = (bool) $data['odrzavanje'];
        $s->odrzavanje_lozinka = $data['odrzavanje_lozinka'] ?? '';
        $s->odrzavanje_minuta = (int) $data['odrzavanje_minuta'];
        $s->odrzavanje_poruka = $data['odrzavanje_poruka'] ?? '';
        $s->captcha_site_key = trim($data['captcha_site_key'] ?? '');

        if (filled($data['captcha_secret'] ?? null)) {
            $s->captcha_secret = trim($data['captcha_secret']);
        } elseif (blank($s->captcha_site_key)) {
            $s->captcha_secret = '';
        }

        $s->save();

        return back()->with('status', 'Postavke su sačuvane.');
    }

    protected function mapa(array $vrijednosti): array
    {
        return collect($vrijednosti)
            ->map(fn ($v) => trim((string) $v))
            ->filter(fn ($v) => $v !== '')
            ->all();
    }

    public function logo(Request $request): RedirectResponse
    {
        $request->validate(['image' => ['required', 'image', 'max:4096']]);

        $s = app(SiteSettings::class);

        if ($s->brand_logo) {
            Storage::disk('public')->delete($s->brand_logo);
        }

        $s->brand_logo = $request->file('image')->store('logo', 'public');
        $s->save();

        return back()->with('status', 'Logo je sačuvan.');
    }

    public function obrisiLogo(): RedirectResponse
    {
        $s = app(SiteSettings::class);

        if ($s->brand_logo) {
            Storage::disk('public')->delete($s->brand_logo);
        }

        $s->brand_logo = '';
        $s->save();

        return back()->with('status', 'Logo je uklonjen.');
    }
}
