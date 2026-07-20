<?php

namespace App\Http\Controllers\Administracija;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ContentWorkflow;
use App\Support\ResourceUrls;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

abstract class AdminResourceController extends Controller
{
    protected const TABOVI = [
        'objavljeni' => ContentStatus::Objavljeno,
        'na-cekanju' => ContentStatus::Poslano,
        'nacrti' => ContentStatus::Nacrt,
        'arhiva' => ContentStatus::Arhivirano,
    ];

    public const GALERIJA_MAX = 18;

    abstract protected function model(): string;

    abstract protected function view(): string;

    abstract protected function base(): string;

    abstract protected function categoryType(): string;

    abstract protected function tip(): string;

    abstract protected function nazivJednine(): string;

    abstract protected function propKey(): string;

    protected function hasMedia(): bool
    {
        return true;
    }

    protected function hasCategory(): bool
    {
        return true;
    }

    abstract protected function rules(?Model $model): array;

    abstract protected function assign(Model $model, array $data): void;

    abstract protected function detaljiExtra(Model $model): array;

    protected function rowPodnaslov(Model $model): string
    {
        return '';
    }

    public function index(Request $request): Response
    {
        $tab = $request->query('tab', 'sve');
        $kategorija = $request->query('kategorija');
        $status = self::TABOVI[$tab] ?? null;

        $model = $this->model();

        $relacije = array_filter(['user', $this->hasCategory() ? 'category' : null, $this->hasMedia() ? 'media' : null]);

        $stavke = $model::query()
            ->with($relacije)
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($this->hasCategory() && $kategorija, fn ($q) => $q->where('category_id', $kategorija))
            ->latest('id')
            ->paginate(15)
            ->withQueryString()
            ->through(fn (Model $m) => $this->row($m));

        return Inertia::render($this->view().'/Lista', [
            'stavke' => $stavke,
            'filteri' => [
                'tab' => $tab,
                'kategorija' => $kategorija ? (int) $kategorija : null,
            ],
            'brojaci' => [
                'objavljeni' => $model::where('status', ContentStatus::Objavljeno)->count(),
                'naCekanju' => $model::where('status', ContentStatus::Poslano)->count(),
                'nacrti' => $model::where('status', ContentStatus::Nacrt)->count(),
            ],
            'kategorije' => $this->kategorije(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render($this->view().'/Forma', [
            $this->propKey() => null,
            'kategorije' => $this->kategorije(),
            'statusi' => $this->statusi(),
            'segmenti' => (array) config('resources.types.'.$this->tip().'.segment'),
        ]);
    }

    protected function find(int $id): Model
    {
        return $this->model()::findOrFail($id);
    }

    public function edit(int $id): Response
    {
        $stavka = $this->find($id);
        $stavka->load(array_filter(['user', 'tags', $this->hasCategory() ? 'category' : null, $this->hasMedia() ? 'media' : null]));

        return Inertia::render($this->view().'/Forma', [
            $this->propKey() => $this->detalji($stavka),
            'kategorije' => $this->kategorije(),
            'statusi' => $this->statusi(),
            'segmenti' => (array) config('resources.types.'.$this->tip().'.segment'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $model = $this->model();
        $stavka = new $model();
        $this->fill($stavka, $data);

        return redirect("/administracija/{$this->base()}/{$stavka->id}/uredi")
            ->with('status', $this->nazivJednine().' „'.($data['naslov']['sr'] ?? '').'" je kreiran.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $stavka = $this->find($id);
        $data = $this->validated($request, $stavka);
        $this->fill($stavka, $data);

        return back(303)->with('status', $this->nazivJednine().' je sačuvan.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->find($id)->delete();

        return redirect("/administracija/{$this->base()}")->with('status', $this->nazivJednine().' je obrisan.');
    }

    public function approve(int $id, ContentWorkflow $workflow): RedirectResponse
    {
        $workflow->approve($this->find($id));

        return back(303)->with('status', $this->nazivJednine().' je odobren i objavljen.');
    }

    public function reject(Request $request, int $id, ContentWorkflow $workflow): RedirectResponse
    {
        $data = $request->validate(['rejection_reason' => ['required', 'string', 'max:1000']]);
        $workflow->reject($this->find($id), $data['rejection_reason']);

        return back(303)->with('status', $this->nazivJednine().' je odbijen.');
    }

    public function uploadNaslovna(Request $request, int $id): RedirectResponse
    {
        $request->validate(['image' => ['required', 'image', 'max:8192']]);

        $stavka = $this->find($id);
        $stavka->clearMediaCollection('naslovna');
        $stavka->addMediaFromRequest('image')->toMediaCollection('naslovna');

        return back(303)->with('status', 'Naslovna slika je sačuvana.');
    }

    public function destroyNaslovna(int $id): RedirectResponse
    {
        $this->find($id)->clearMediaCollection('naslovna');

        return back(303)->with('status', 'Naslovna slika je uklonjena.');
    }

    public function uploadGalerija(Request $request, int $id): RedirectResponse
    {
        $stavka = $this->find($id);

        $request->validate([
            'galerija' => ['required', 'array'],
            'galerija.*' => ['image', 'max:8192'],
        ]);

        $postojece = $stavka->getMedia('galerija')->count();
        $novih = count($request->file('galerija', []));

        if ($postojece + $novih > self::GALERIJA_MAX) {
            return back(303)->with('error', 'Galerija može imati najviše '.self::GALERIJA_MAX.' fotografija.');
        }

        foreach ($request->file('galerija', []) as $file) {
            $stavka->addMedia($file)->toMediaCollection('galerija');
        }

        return back(303)->with('status', 'Fotografije su dodane.');
    }

    public function replaceGalerija(Request $request, Media $media): RedirectResponse
    {
        abort_unless($media->model_type === $this->model() && $media->collection_name === 'galerija', 404);

        $request->validate(['image' => ['required', 'image', 'max:8192']]);

        $stavka = $media->model;
        $pozicija = $media->order_column;

        $novi = $stavka->addMediaFromRequest('image')->toMediaCollection('galerija');
        $novi->order_column = $pozicija;
        $novi->save();

        $media->delete();

        return back(303)->with('status', 'Fotografija je izmijenjena.');
    }

    public function destroyGalerija(Media $media): RedirectResponse
    {
        abort_unless($media->model_type === $this->model() && $media->collection_name === 'galerija', 404);

        $media->delete();

        return back(303)->with('status', 'Fotografija je uklonjena.');
    }

    public function reorderGalerija(Request $request, int $id): RedirectResponse
    {
        $stavka = $this->find($id);

        $data = $request->validate([
            'redoslijed' => ['present', 'array'],
            'redoslijed.*' => ['integer'],
        ]);

        $validni = $stavka->getMedia('galerija')->pluck('id')->all();

        $ids = collect($data['redoslijed'])
            ->filter(fn ($id) => in_array((int) $id, $validni, true))
            ->values()
            ->all();

        Media::setNewOrder($ids);

        return back(303)->with('status', 'Redoslijed fotografija je sačuvan.');
    }

    protected function validated(Request $request, ?Model $model = null): array
    {
        $common = [
            'naslov' => ['required', 'array'],
            'naslov.sr' => ['required', 'string', 'max:255'],
            'naslov.*' => ['nullable', 'string', 'max:255'],
            'slug' => ['array'],
            'slug.*' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9\-]+$/'],
            'status' => ['required', 'string'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:100'],
        ];

        if ($this->hasCategory()) {
            $common['category_id'] = ['nullable', 'exists:categories,id'];
        }

        return $request->validate(array_merge($common, $this->rules($model)));
    }

    protected function fill(Model $stavka, array $data): void
    {
        $stavka->setTranslations('naslov', $this->mapa($data['naslov']));
        $stavka->slug = $this->mapa($data['slug'] ?? []);

        if ($this->hasCategory()) {
            $stavka->category_id = $data['category_id'] ?? null;
        }

        $this->assign($stavka, $data);

        $status = ContentStatus::tryFrom($data['status']) ?? ContentStatus::Nacrt;
        $stavka->status = $status;

        if ($status === ContentStatus::Objavljeno && ! $stavka->published_at) {
            $stavka->published_at = now();
        }

        $stavka->save();

        $this->syncTags($stavka, $data['tags'] ?? []);
    }

    protected function syncTags(Model $stavka, array $imena): void
    {
        $ids = collect($imena)
            ->map(fn ($ime) => trim((string) $ime))
            ->filter()
            ->unique()
            ->map(fn ($ime) => Tag::firstOrCreate(['slug' => Str::slug($ime)], ['name' => ['sr' => $ime]])->id)
            ->all();

        $stavka->tags()->sync($ids);
    }

    protected function detalji(Model $stavka): array
    {
        return array_merge([
            'id' => $stavka->id,
            'naslov' => $stavka->getTranslations('naslov'),
            'slug' => $stavka->slug,
            'url' => ResourceUrls::detail($stavka, 'sr'),
            'category_id' => $stavka->category_id,
            'status' => $stavka->status->value,
            'rejection_reason' => $stavka->rejection_reason,
            'publishedAt' => $stavka->published_at?->translatedFormat('d.m.Y.'),
            'tags' => $stavka->tags->map(fn (Tag $t) => $t->getTranslations('name')['sr'] ?? $t->name)->values()->all(),
            'naslovna' => $this->hasMedia() ? ($stavka->getFirstMediaUrl('naslovna') ?: null) : null,
            'galerija' => $this->hasMedia()
                ? $stavka->getMedia('galerija')->map(fn (Media $m) => ['id' => $m->id, 'src' => $m->getUrl()])->all()
                : [],
        ], $this->detaljiExtra($stavka));
    }

    protected function row(Model $stavka): array
    {
        $category = $this->hasCategory() ? $stavka->category : null;

        return [
            'id' => $stavka->id,
            'naslov' => $stavka->getTranslations('naslov')['sr'] ?? '(bez naslova)',
            'opis' => $this->rowPodnaslov($stavka),
            'kategorija' => $category ? [
                'label' => $category->getTranslations('label')['sr'] ?? $category->label,
                'color' => $category->color,
            ] : null,
            'autor' => $stavka->user?->name,
            'status' => $stavka->status->value,
            'datum' => ($stavka->published_at ?? $stavka->created_at)?->translatedFormat('d.m.Y.'),
            'url' => ResourceUrls::detail($stavka, 'sr'),
        ];
    }

    protected function kategorije(): array
    {
        if (! $this->hasCategory()) {
            return [];
        }

        return Category::where('type', $this->categoryType())
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

    protected function trMap(?array $vrijednosti): array
    {
        return $this->mapa((array) ($vrijednosti ?? []));
    }
}
