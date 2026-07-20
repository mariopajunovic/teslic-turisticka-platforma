<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class NavigacijaController extends Controller
{
    public function index(Request $request): Response
    {
        $meniji = Menu::with(['rootItems.children'])->orderBy('id')->get();

        $izabran = $request->query('meni');
        $aktivan = $meniji->firstWhere('key', $izabran) ?? $meniji->first();

        return Inertia::render('Navigacija/Lista', [
            'meniji' => $meniji->map(fn (Menu $m) => [
                'id' => $m->id,
                'key' => $m->key,
                'name' => $m->getTranslations('name')['sr'] ?? $m->key,
                'broj' => $m->rootItems->count() + $m->rootItems->sum(fn ($i) => $i->children->count()),
            ])->all(),
            'aktivan' => $aktivan ? [
                'id' => $aktivan->id,
                'key' => $aktivan->key,
                'name' => $aktivan->getTranslations('name')['sr'] ?? $aktivan->key,
                'stavke' => $this->stavke($aktivan),
            ] : null,
            'ciljevi' => $this->ciljevi(),
        ]);
    }

    public function store(Request $request, Menu $menu): RedirectResponse
    {
        $data = $this->validated($request);

        $stavka = new MenuItem();
        $stavka->menu_id = $menu->id;
        $stavka->sort = (int) MenuItem::where('menu_id', $menu->id)->whereNull('parent_id')->max('sort') + 1;
        $this->fill($stavka, $data);

        return back(303)->with('status', 'Stavka je dodana.');
    }

    public function update(Request $request, MenuItem $stavka): RedirectResponse
    {
        $data = $this->validated($request);

        $this->fill($stavka, $data);

        return back(303)->with('status', 'Stavka je sačuvana.');
    }

    public function destroy(MenuItem $stavka): RedirectResponse
    {
        $stavka->children()->delete();
        $stavka->delete();

        return back(303)->with('status', 'Stavka je uklonjena.');
    }

    public function toggle(MenuItem $stavka): RedirectResponse
    {
        $stavka->visible = ! $stavka->visible;
        $stavka->save();

        return back(303);
    }

    public function reorder(Request $request, Menu $menu): RedirectResponse
    {
        $data = $request->validate([
            'stavke' => ['present', 'array'],
            'stavke.*.id' => ['required', 'integer'],
            'stavke.*.parent_id' => ['nullable', 'integer'],
        ]);

        foreach ($data['stavke'] as $pozicija => $red) {
            MenuItem::where('id', $red['id'])->where('menu_id', $menu->id)->update([
                'parent_id' => $red['parent_id'] ?: null,
                'sort' => $pozicija,
            ]);
        }

        return back(303)->with('status', 'Redoslijed je sačuvan.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'label' => ['required', 'array'],
            'label.sr' => ['required', 'string', 'max:255'],
            'label.*' => ['nullable', 'string', 'max:255'],
            'target_type' => ['required', Rule::in([MenuItem::CILJ_STRANICA, MenuItem::CILJ_KATEGORIJA, MenuItem::CILJ_VANJSKI])],
            'target_id' => ['nullable', 'integer'],
            'url' => ['nullable', 'string', 'max:2048'],
            'parent_id' => ['nullable', 'exists:menu_items,id'],
        ]);
    }

    protected function fill(MenuItem $stavka, array $data): void
    {
        $stavka->setTranslations('label', collect($data['label'])->map(fn ($v) => trim((string) $v))->filter()->all());
        $stavka->target_type = $data['target_type'];
        $stavka->target_id = $data['target_type'] === MenuItem::CILJ_VANJSKI ? null : ($data['target_id'] ?: null);
        $stavka->url = $data['target_type'] === MenuItem::CILJ_VANJSKI ? ($data['url'] ?: null) : null;

        if (array_key_exists('parent_id', $data)) {
            $stavka->parent_id = $data['parent_id'] ?: null;
        }

        $stavka->save();
    }

    protected function stavke(Menu $menu): array
    {
        $red = [];

        foreach ($menu->rootItems as $stavka) {
            $red[] = $this->stavka($stavka, 0);

            foreach ($stavka->children as $dijete) {
                $red[] = $this->stavka($dijete, 1);
            }
        }

        return $red;
    }

    protected function stavka(MenuItem $stavka, int $dubina): array
    {
        $url = $stavka->razrijeseniUrl();

        return [
            'id' => $stavka->id,
            'label' => $stavka->getTranslations('label')['sr'] ?? '',
            'labelTranslations' => $stavka->getTranslations('label'),
            'targetType' => $stavka->tipCilja(),
            'targetId' => $stavka->target_id,
            'url' => $url,
            'vanjskiUrl' => $stavka->url,
            'mrtav' => $url === null,
            'visible' => (bool) $stavka->visible,
            'dubina' => $dubina,
            'parentId' => $stavka->parent_id,
        ];
    }

    protected function ciljevi(): array
    {
        $stranice = [];

        foreach (Page::whereNull('parent_id')->orderBy('sort')->orderBy('id')->get() as $roditelj) {
            $stranice[] = ['value' => $roditelj->id, 'label' => $roditelj->getTranslations('title')['sr'] ?? $roditelj->slugFor('sr'), 'putanja' => $roditelj->pathFor('sr')];

            foreach ($roditelj->children as $dijete) {
                $stranice[] = ['value' => $dijete->id, 'label' => '- '.($dijete->getTranslations('title')['sr'] ?? $dijete->slugFor('sr')), 'putanja' => $dijete->pathFor('sr')];
            }
        }

        return [
            'stranice' => $stranice,
            'kategorije' => Category::orderBy('type')->orderBy('sort')->get()
                ->map(fn (Category $c) => [
                    'value' => $c->id,
                    'label' => ($c->getTranslations('label')['sr'] ?? $c->key),
                    'putanja' => \App\Support\ResourceUrls::category($c),
                ])->all(),
        ];
    }
}
