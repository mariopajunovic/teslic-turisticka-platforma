<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use App\Models\Story;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class CategoriesController extends Controller
{
    protected const TIPOVI = [
        'domace' => 'Domaći biznisi',
        'turizam' => 'Turizam',
        'dogadjaj' => 'Događaji',
        'price' => 'Priče',
        'oglasi' => 'Oglasi',
    ];

    protected const MODELI = [
        'domace' => Business::class,
        'turizam' => Location::class,
        'dogadjaj' => Event::class,
        'price' => Story::class,
        'oglasi' => Ad::class,
    ];

    public function index(Request $request): Response
    {
        $tip = $request->query('tip');
        $tip = array_key_exists($tip, self::TIPOVI) ? $tip : null;
        $q = trim((string) $request->query('q', ''));

        $kategorije = Category::query()
            ->when($tip, fn ($query) => $query->where('type', $tip))
            ->when($q !== '', fn ($query) => $query->where(
                fn ($sub) => $sub->where('key', 'like', "%{$q}%")->orWhere('label->sr', 'like', "%{$q}%")
            ))
            ->orderByRaw('FIELD(type, "domace", "turizam", "dogadjaj", "price", "oglasi")')
            ->orderBy('sort')
            ->orderBy('id')
            ->paginate(50)
            ->withQueryString();

        $brojevi = $this->brojStavki();

        $kategorije->through(fn (Category $c) => $this->row($c, $brojevi));

        return Inertia::render('Kategorije/Lista', [
            'kategorije' => $kategorije,
            'filteri' => [
                'tip' => $tip ?? 'sve',
                'q' => $q,
            ],
            'tipovi' => $this->tipoviZaTabove(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Kategorije/Forma', [
            'kategorija' => null,
            'tipovi' => $this->tipoviOpcije(),
        ]);
    }

    public function edit(Category $category): Response
    {
        return Inertia::render('Kategorije/Forma', [
            'kategorija' => $this->detalji($category),
            'tipovi' => $this->tipoviOpcije(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $category = new Category();
        $this->fill($category, $data);

        return redirect("/administracija/kategorije/{$category->id}/uredi")
            ->with('status', 'Kategorija „'.$data['label']['sr'].'" je kreirana.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request, $category);

        $this->fill($category, $data);

        return back(303)->with('status', 'Kategorija je sačuvana.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($this->brojStavki()[$category->id] ?? 0) {
            return back(303)->with('error', 'Kategorija se ne može obrisati jer sadrži stavke.');
        }

        $category->delete();

        return redirect('/administracija/kategorije')->with('status', 'Kategorija je obrisana.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'redoslijed' => ['present', 'array'],
            'redoslijed.*' => ['integer'],
        ]);

        foreach ($data['redoslijed'] as $pozicija => $id) {
            Category::where('id', $id)->update(['sort' => $pozicija]);
        }

        return back(303)->with('status', 'Redoslijed kategorija je sačuvan.');
    }

    protected function validated(Request $request, ?Category $category = null): array
    {
        return $request->validate([
            'label' => ['required', 'array'],
            'label.sr' => ['required', 'string', 'max:255'],
            'label.*' => ['nullable', 'string', 'max:255'],
            'slug' => ['array'],
            'slug.*' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9\-]+$/'],
            'opis' => ['array'],
            'opis.*' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', Rule::in(array_keys(self::TIPOVI))],
            'color' => ['nullable', 'string', 'max:9', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'icon' => ['nullable', 'string', 'max:100'],
            'visible' => ['boolean'],
        ]);
    }

    protected function fill(Category $category, array $data): void
    {
        $category->setTranslations('label', $this->mapa($data['label']));
        $category->slug = $this->mapa($data['slug'] ?? []);
        $category->setTranslations('opis', $this->mapa($data['opis'] ?? []));
        $category->type = $data['type'];
        $category->color = $data['color'] ?? null;
        $category->icon = $data['icon'] ?? null;
        $category->visible = (bool) ($data['visible'] ?? true);

        if ($category->sort === null) {
            $category->sort = (int) Category::where('type', $data['type'])->max('sort') + 1;
        }

        $category->save();
    }

    protected function detalji(Category $category): array
    {
        return [
            'id' => $category->id,
            'key' => $category->key,
            'slug' => (array) $category->slug,
            'label' => $category->getTranslations('label'),
            'opis' => $category->getTranslations('opis'),
            'type' => $category->type,
            'color' => $category->color,
            'icon' => $category->icon,
            'visible' => (bool) $category->visible,
            'brojStavki' => $this->brojStavki()[$category->id] ?? 0,
            'url' => $this->javniUrl($category),
        ];
    }

    protected function row(Category $category, array $brojevi): array
    {
        return [
            'id' => $category->id,
            'key' => $category->key,
            'label' => $category->getTranslations('label')['sr'] ?? $category->key,
            'type' => $category->type,
            'tipLabel' => self::TIPOVI[$category->type] ?? ($category->type ?: '-'),
            'color' => $category->color,
            'icon' => $category->icon,
            'sort' => $category->sort,
            'visible' => (bool) $category->visible,
            'brojStavki' => $brojevi[$category->id] ?? 0,
            'prijevodi' => $this->prijevodi($category),
        ];
    }

    protected function prijevodi(Category $category): array
    {
        return collect($category->getTranslations('label'))
            ->filter(fn ($v) => trim((string) $v) !== '')
            ->keys()
            ->values()
            ->all();
    }

    protected function brojStavki(): array
    {
        $counts = [];

        foreach (self::MODELI as $model) {
            $grupe = $model::query()
                ->whereNotNull('category_id')
                ->selectRaw('category_id, count(*) as ukupno')
                ->groupBy('category_id')
                ->pluck('ukupno', 'category_id');

            foreach ($grupe as $id => $ukupno) {
                $counts[$id] = ($counts[$id] ?? 0) + (int) $ukupno;
            }
        }

        return $counts;
    }

    protected function javniUrl(Category $category): ?string
    {
        $osnove = [
            'domace' => '/domace-je-najbolje/kategorija/',
            'turizam' => '/turizam/kategorija/',
            'price' => '/price/kategorija/',
        ];

        $osnova = $osnove[$category->type] ?? null;

        return $osnova ? $osnova.$category->slugFor('sr') : null;
    }

    protected function tipoviZaTabove(): array
    {
        return collect(self::TIPOVI)
            ->map(fn ($label, $key) => ['key' => $key, 'label' => $label])
            ->values()
            ->all();
    }

    protected function tipoviOpcije(): array
    {
        return collect(self::TIPOVI)
            ->map(fn ($label, $key) => ['value' => $key, 'label' => $label])
            ->values()
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
