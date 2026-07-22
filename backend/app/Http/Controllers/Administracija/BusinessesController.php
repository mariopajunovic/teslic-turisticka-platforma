<?php

namespace App\Http\Controllers\Administracija;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ContentWorkflow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Support\ResourceUrls;

class BusinessesController extends Controller
{
    protected const TABOVI = [
        'objavljeni' => ContentStatus::Objavljeno,
        'na-cekanju' => ContentStatus::Poslano,
        'nacrti' => ContentStatus::Nacrt,
        'arhiva' => ContentStatus::Arhivirano,
    ];

    public function index(Request $request): Response
    {
        $tab = $request->query('tab', 'sve');
        $kategorija = $request->query('kategorija');

        $status = self::TABOVI[$tab] ?? null;

        $biznisi = Business::query()
            ->with(['category', 'user', 'media'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($kategorija, fn ($query) => $query->where('category_id', $kategorija))
            ->latest('id')
            ->paginate(15)
            ->withQueryString()
            ->through(fn (Business $b) => $this->row($b));

        return Inertia::render('Biznisi/Lista', [
            'biznisi' => $biznisi,
            'filteri' => [
                'tab' => $tab,
                'kategorija' => $kategorija ? (int) $kategorija : null,
            ],
            'brojaci' => [
                'objavljeni' => Business::where('status', ContentStatus::Objavljeno)->count(),
                'naCekanju' => Business::where('status', ContentStatus::Poslano)->count(),
                'nacrti' => Business::where('status', ContentStatus::Nacrt)->count(),
            ],
            'kategorije' => $this->kategorije(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Biznisi/Forma', [
            'biznis' => null,
            'kategorije' => $this->kategorije(),
            'statusi' => $this->statusi(),
            'segmenti' => (array) config('resources.types.business.segment'),
        ]);
    }

    public function edit(Business $business): Response
    {
        $business->load(['category', 'user', 'tags', 'media']);

        return Inertia::render('Biznisi/Forma', [
            'biznis' => $this->detalji($business),
            'kategorije' => $this->kategorije(),
            'statusi' => $this->statusi(),
            'segmenti' => (array) config('resources.types.business.segment'),
            'pending' => $this->pendingPregled($business),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $business = new Business();
        $this->fill($business, $data);

        return redirect("/administracija/biznisi/{$business->id}/uredi")
            ->with('status', 'Biznis „'.$data['naslov']['sr'].'" je kreiran.');
    }

    public function update(Request $request, Business $business): RedirectResponse
    {
        $data = $this->validated($request, $business);

        $this->fill($business, $data);

        return back(303)->with('status', 'Biznis je sačuvan.');
    }

    public function destroy(Business $business): RedirectResponse
    {
        $business->delete();

        return redirect('/administracija/biznisi')->with('status', 'Biznis je obrisan.');
    }

    public function approve(Business $business, ContentWorkflow $workflow): RedirectResponse
    {
        $workflow->approve($business);

        return back(303)->with('status', 'Biznis je odobren i objavljen.');
    }

    public function reject(Request $request, Business $business, ContentWorkflow $workflow): RedirectResponse
    {
        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $workflow->reject($business, $data['rejection_reason']);

        return back(303)->with('status', 'Biznis je odbijen.');
    }

    public function approveChanges(Business $business): RedirectResponse
    {
        $business->primijeniPending();

        return back(303)->with('status', 'Izmjene su odobrene i objavljene.');
    }

    public function returnChanges(Request $request, Business $business): RedirectResponse
    {
        $data = $request->validate(['pending_reason' => ['required', 'string', 'max:1000']]);

        $business->vratiPending($data['pending_reason']);
        $business->user?->notify(new \App\Notifications\IzmjeneVracene($business, $data['pending_reason']));

        return back(303)->with('status', 'Izmjene su vraćene vlasniku na doradu.');
    }

    public function rejectChanges(Request $request, Business $business): RedirectResponse
    {
        $request->validate(['rejection_reason' => ['nullable', 'string', 'max:1000']]);

        $business->odbaciPending();

        return back(303)->with('status', 'Izmjene su odbijene.');
    }

    protected function pendingPregled(Business $business): ?array
    {
        if (! $business->pending) {
            return null;
        }

        $p = $business->pending;
        $polja = [
            'Naziv' => [(string) $business->naslov, (string) ($p['naslov'] ?? '')],
            'Kratki opis' => [(string) $business->opis, (string) ($p['opis'] ?? '')],
            'Detaljan opis' => [strip_tags((string) $business->opis_dug), strip_tags((string) ($p['opis_dug'] ?? ''))],
            'Lokacija' => [(string) $business->lokacija, (string) ($p['lokacija'] ?? '')],
            'JIB' => [(string) $business->jib, (string) ($p['jib'] ?? '')],
            'Godina osnivanja' => [(string) $business->godina_osnivanja, (string) ($p['godina_osnivanja'] ?? '')],
            'Raspon cijena' => [(string) $business->cijena_raspon, (string) ($p['cijena_raspon'] ?? '')],
            'Usluge' => [implode(', ', $business->getTranslations('usluge')['sr'] ?? []), (string) ($p['usluge'] ?? '')],
        ];

        $diff = collect($polja)
            ->map(fn ($v, $k) => ['polje' => $k, 'staro' => $v[0], 'novo' => $v[1]])
            ->filter(fn ($r) => $r['staro'] !== $r['novo'])
            ->values()
            ->all();

        return [
            'diff' => $diff,
            'naslovnaNova' => ($m = $business->getFirstMedia('naslovna_pending')) ? \App\Http\Controllers\SecureMediaController::url($m) : null,
            'galerijaNova' => $business->getMedia('galerija_pending')->map(fn ($m) => \App\Http\Controllers\SecureMediaController::url($m))->values()->all(),
        ];
    }

    public function uploadNaslovna(Request $request, Business $business): RedirectResponse
    {
        $request->validate(['image' => ['required', 'image', 'max:8192']]);

        $business->clearMediaCollection('naslovna');
        $business->addMediaFromRequest('image')->toMediaCollection('naslovna');

        return back(303)->with('status', 'Naslovna slika je sačuvana.');
    }

    public function destroyNaslovna(Business $business): RedirectResponse
    {
        $business->clearMediaCollection('naslovna');

        return back(303)->with('status', 'Naslovna slika je uklonjena.');
    }

    public function uploadLogo(Request $request, Business $business): RedirectResponse
    {
        $request->validate(['image' => ['required', 'image', 'max:4096']]);

        $business->clearMediaCollection('logo');
        $business->addMediaFromRequest('image')->toMediaCollection('logo');

        return back(303)->with('status', 'Logo je sačuvan.');
    }

    public function destroyLogo(Business $business): RedirectResponse
    {
        $business->clearMediaCollection('logo');

        return back(303)->with('status', 'Logo je uklonjen.');
    }

    public const GALERIJA_MAX = 18;

    public function uploadGalerija(Request $request, Business $business): RedirectResponse
    {
        $request->validate([
            'galerija' => ['required', 'array'],
            'galerija.*' => ['image', 'max:8192'],
        ]);

        $postojece = $business->getMedia('galerija')->count();
        $novih = count($request->file('galerija', []));

        if ($postojece + $novih > self::GALERIJA_MAX) {
            return back(303)->with('error', 'Galerija može imati najviše '.self::GALERIJA_MAX.' fotografija.');
        }

        foreach ($request->file('galerija', []) as $file) {
            $business->addMedia($file)->toMediaCollection('galerija');
        }

        return back(303)->with('status', 'Fotografije su dodane.');
    }

    public function replaceGalerija(Request $request, Media $media): RedirectResponse
    {
        abort_unless($media->model_type === Business::class && $media->collection_name === 'galerija', 404);

        $request->validate(['image' => ['required', 'image', 'max:8192']]);

        $business = $media->model;
        $pozicija = $media->order_column;

        $novi = $business->addMediaFromRequest('image')->toMediaCollection('galerija');
        $novi->order_column = $pozicija;
        $novi->save();

        $media->delete();

        return back(303)->with('status', 'Fotografija je izmijenjena.');
    }

    public function destroyGalerija(Media $media): RedirectResponse
    {
        abort_unless($media->model_type === Business::class && $media->collection_name === 'galerija', 404);

        $media->delete();

        return back(303)->with('status', 'Fotografija je uklonjena.');
    }

    public function reorderGalerija(Request $request, Business $business): RedirectResponse
    {
        $data = $request->validate([
            'redoslijed' => ['present', 'array'],
            'redoslijed.*' => ['integer'],
        ]);

        $validni = $business->getMedia('galerija')->pluck('id')->all();

        $ids = collect($data['redoslijed'])
            ->filter(fn ($id) => in_array((int) $id, $validni, true))
            ->values()
            ->all();

        Media::setNewOrder($ids);

        return back(303)->with('status', 'Redoslijed fotografija je sačuvan.');
    }

    protected function validated(Request $request, ?Business $business = null): array
    {
        return $request->validate([
            'naslov' => ['required', 'array'],
            'naslov.sr' => ['required', 'string', 'max:255'],
            'naslov.*' => ['nullable', 'string', 'max:255'],
            'slug' => ['array'],
            'slug.*' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9\-]+$/'],
            'opis' => ['array'],
            'opis.*' => ['nullable', 'string', 'max:1000'],
            'opis_dug' => ['array'],
            'opis_dug.*' => ['nullable', 'string'],
            'lokacija' => ['array'],
            'lokacija.*' => ['nullable', 'string', 'max:255'],
            'radno_vrijeme' => ['array'],
            'radno_vrijeme.*.zatvoreno' => ['boolean'],
            'radno_vrijeme.*.od' => ['nullable', 'string', 'max:10'],
            'radno_vrijeme.*.do' => ['nullable', 'string', 'max:10'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'kontakt' => ['array'],
            'kontakt.telefon' => ['nullable', 'string', 'max:100'],
            'kontakt.email' => ['nullable', 'string', 'max:255'],
            'kontakt.adresa' => ['nullable', 'string', 'max:255'],
            'kontakt.web' => ['nullable', 'string', 'max:255'],
            'kontakt.viber' => ['nullable', 'string', 'max:40'],
            'kontakt.whatsapp' => ['nullable', 'string', 'max:40'],
            'drustvene' => ['array'],
            'drustvene.facebook' => ['nullable', 'string', 'max:255'],
            'drustvene.instagram' => ['nullable', 'string', 'max:255'],
            'drustvene.youtube' => ['nullable', 'string', 'max:255'],
            'drustvene.tiktok' => ['nullable', 'string', 'max:255'],
            'usluge' => ['array'],
            'usluge.*' => ['array'],
            'usluge.*.*' => ['nullable', 'string', 'max:120'],
            'cijena_raspon' => ['nullable', 'string', 'max:8'],
            'godina_osnivanja' => ['nullable', 'integer', 'min:1800', 'max:2100'],
            'jib' => ['nullable', 'digits:13', Rule::unique('businesses', 'jib')->ignore($business?->id)],
            'nacin_placanja' => ['array'],
            'nacin_placanja.*' => ['boolean'],
            'lat' => ['nullable', 'numeric', 'between:-90,90'],
            'lng' => ['nullable', 'numeric', 'between:-180,180'],
            'preporuceno' => ['boolean'],
            'status' => ['required', 'string'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:100'],
        ]);
    }

    protected function fill(Business $business, array $data): void
    {
        $business->setTranslations('naslov', $this->mapa($data['naslov']));
        $business->slug = $this->mapa($data['slug'] ?? []);
        $business->setTranslations('opis', $this->mapa($data['opis'] ?? []));
        $business->setTranslations('opis_dug', $this->mapa($data['opis_dug'] ?? []));
        $business->setTranslations('lokacija', $this->mapa($data['lokacija'] ?? []));
        $business->radno_vrijeme = $this->radnoVrijeme($data['radno_vrijeme'] ?? []);

        $business->category_id = $data['category_id'] ?? null;
        $business->kontakt = $this->kontakt($data['kontakt'] ?? []);
        $business->drustvene = $this->drustvene($data['drustvene'] ?? []);
        $business->setTranslations('usluge', collect($data['usluge'] ?? [])
            ->only((array) config('locales.content'))
            ->map(fn ($arr) => collect((array) $arr)->map(fn ($u) => trim((string) $u))->filter()->values()->all())
            ->all());
        $business->cijena_raspon = in_array($data['cijena_raspon'] ?? '', ['€', '€€', '€€€'], true) ? $data['cijena_raspon'] : null;
        $business->godina_osnivanja = $data['godina_osnivanja'] ?? null;
        $business->jib = $data['jib'] ?? null;
        $business->nacin_placanja = array_filter([
            'gotovina' => (bool) ($data['nacin_placanja']['gotovina'] ?? false),
            'kartica' => (bool) ($data['nacin_placanja']['kartica'] ?? false),
            'virman' => (bool) ($data['nacin_placanja']['virman'] ?? false),
        ]);
        $business->lat = $data['lat'] ?? null;
        $business->lng = $data['lng'] ?? null;
        $business->preporuceno = (bool) ($data['preporuceno'] ?? false);

        $status = ContentStatus::tryFrom($data['status']) ?? ContentStatus::Nacrt;
        $business->status = $status;

        if ($status === ContentStatus::Objavljeno && ! $business->published_at) {
            $business->published_at = now();
        }

        $business->save();

        $this->syncTags($business, $data['tags'] ?? []);
    }

    protected function syncTags(Business $business, array $imena): void
    {
        $ids = collect($imena)
            ->map(fn ($ime) => trim((string) $ime))
            ->filter()
            ->unique()
            ->map(function ($ime) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($ime)],
                    ['name' => ['sr' => $ime]],
                );

                return $tag->id;
            })
            ->all();

        $business->tags()->sync($ids);
    }

    protected function detalji(Business $business): array
    {
        return [
            'id' => $business->id,
            'naslov' => $business->getTranslations('naslov'),
            'opis' => $business->getTranslations('opis'),
            'opis_dug' => $business->getTranslations('opis_dug'),
            'lokacija' => $business->getTranslations('lokacija'),
            'radno_vrijeme' => (array) $business->radno_vrijeme,
            'slug' => (array) $business->slug,
            'url' => ResourceUrls::detail($business, 'sr'),
            'category_id' => $business->category_id,
            'kontakt' => $this->kontakt($business->kontakt ?? []),
            'drustvene' => $this->drustvene((array) $business->drustvene),
            'usluge' => $business->getTranslations('usluge'),
            'cijena_raspon' => $business->cijena_raspon,
            'godina_osnivanja' => $business->godina_osnivanja,
            'jib' => $business->jib,
            'nacin_placanja' => (array) $business->nacin_placanja,
            'lat' => $business->lat,
            'lng' => $business->lng,
            'preporuceno' => (bool) $business->preporuceno,
            'status' => $business->status->value,
            'rejection_reason' => $business->rejection_reason,
            'publishedAt' => $business->published_at?->translatedFormat('d.m.Y.'),
            'tags' => $business->tags->map(fn (Tag $t) => $t->getTranslations('name')['sr'] ?? $t->name)->values()->all(),
            'logo' => $business->getFirstMediaUrl('logo') ?: null,
            'naslovna' => $business->getFirstMediaUrl('naslovna') ?: null,
            'galerija' => $business->getMedia('galerija')->map(fn (Media $m) => [
                'id' => $m->id,
                'src' => $m->getUrl(),
            ])->all(),
        ];
    }

    protected function row(Business $business): array
    {
        $category = $business->category;

        return [
            'id' => $business->id,
            'naslov' => $business->getTranslations('naslov')['sr'] ?? '(bez naslova)',
            'opis' => Str::limit(strip_tags($business->getTranslations('opis')['sr'] ?? ''), 80)
                ?: ($business->getTranslations('lokacija')['sr'] ?? ''),
            'kategorija' => $category ? [
                'label' => $category->getTranslations('label')['sr'] ?? $category->label,
                'color' => $category->color,
            ] : null,
            'autor' => $business->user?->name,
            'status' => $business->status->value,
            'pendingStanje' => $business->pending === null ? null : ($business->pending_reason ? 'vraceno' : 'na_cekanju'),
            'datum' => ($business->published_at ?? $business->created_at)?->translatedFormat('d.m.Y.'),
            'url' => ResourceUrls::detail($business, 'sr'),
        ];
    }

    protected function kontakt(array $kontakt): array
    {
        return [
            'telefon' => $this->telefon($kontakt['telefon'] ?? ''),
            'email' => trim((string) ($kontakt['email'] ?? '')),
            'adresa' => trim((string) ($kontakt['adresa'] ?? '')),
            'web' => trim((string) ($kontakt['web'] ?? '')),
            'viber' => $this->telefon($kontakt['viber'] ?? ''),
            'whatsapp' => $this->telefon($kontakt['whatsapp'] ?? ''),
        ];
    }

    protected function telefon(string $broj): string
    {
        $broj = trim($broj);

        if ($broj === '') {
            return '';
        }

        $plus = str_starts_with($broj, '+');
        $cifre = preg_replace('/\D+/', '', $broj);

        if ($cifre === '') {
            return '';
        }

        if (! $plus && str_starts_with($cifre, '0')) {
            $cifre = '387'.substr($cifre, 1);
            $plus = true;
        }

        return ($plus ? '+' : '').$cifre;
    }

    protected function drustvene(array $d): array
    {
        return collect(['facebook', 'instagram', 'youtube', 'tiktok'])
            ->mapWithKeys(fn ($k) => [$k => trim((string) ($d[$k] ?? ''))])
            ->all();
    }

    protected function kategorije(): array
    {
        return Category::where('type', 'domace')
            ->orderBy('sort')
            ->orderBy('label')
            ->get()
            ->map(fn (Category $c) => [
                'value' => $c->id,
                'label' => $c->getTranslations('label')['sr'] ?? $c->label,
                'color' => $c->color,
            ])
            ->all();
    }

    protected function statusi(): array
    {
        return collect(ContentStatus::cases())
            ->map(fn (ContentStatus $s) => ['value' => $s->value, 'label' => $s->getLabel()])
            ->all();
    }

    protected function radnoVrijeme(array $dani): array
    {
        return collect($dani)->take(7)->map(fn ($d) => [
            'zatvoreno' => (bool) ($d['zatvoreno'] ?? false),
            'od' => trim((string) ($d['od'] ?? '')),
            'do' => trim((string) ($d['do'] ?? '')),
        ])->values()->all();
    }

    protected function mapa(array $vrijednosti): array
    {
        return collect($vrijednosti)
            ->map(fn ($v) => trim((string) $v))
            ->filter(fn ($v) => $v !== '')
            ->all();
    }
}
