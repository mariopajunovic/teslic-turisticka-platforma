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
        ]);
    }

    public function edit(Business $business): Response
    {
        $business->load(['category', 'user', 'tags', 'media']);

        return Inertia::render('Biznisi/Forma', [
            'biznis' => $this->detalji($business),
            'kategorije' => $this->kategorije(),
            'statusi' => $this->statusi(),
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
            'category_id' => ['nullable', 'exists:categories,id'],
            'kontakt' => ['array'],
            'kontakt.telefon' => ['nullable', 'string', 'max:100'],
            'kontakt.email' => ['nullable', 'string', 'max:255'],
            'kontakt.adresa' => ['nullable', 'string', 'max:255'],
            'kontakt.web' => ['nullable', 'string', 'max:255'],
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

        $business->category_id = $data['category_id'] ?? null;
        $business->kontakt = $this->kontakt($data['kontakt'] ?? []);
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
            'slug' => (array) $business->slug,
            'url' => '/domace-je-najbolje/'.$business->slugFor('sr'),
            'category_id' => $business->category_id,
            'kontakt' => $this->kontakt($business->kontakt ?? []),
            'lat' => $business->lat,
            'lng' => $business->lng,
            'preporuceno' => (bool) $business->preporuceno,
            'status' => $business->status->value,
            'rejection_reason' => $business->rejection_reason,
            'publishedAt' => $business->published_at?->translatedFormat('d.m.Y.'),
            'tags' => $business->tags->map(fn (Tag $t) => $t->getTranslations('name')['sr'] ?? $t->name)->values()->all(),
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
            'datum' => ($business->published_at ?? $business->created_at)?->translatedFormat('d.m.Y.'),
            'url' => '/domace-je-najbolje/'.$business->slugFor('sr'),
        ];
    }

    protected function kontakt(array $kontakt): array
    {
        return [
            'telefon' => $kontakt['telefon'] ?? '',
            'email' => $kontakt['email'] ?? '',
            'adresa' => $kontakt['adresa'] ?? '',
            'web' => $kontakt['web'] ?? '',
        ];
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

    protected function mapa(array $vrijednosti): array
    {
        return collect($vrijednosti)
            ->map(fn ($v) => trim((string) $v))
            ->filter(fn ($v) => $v !== '')
            ->all();
    }
}
