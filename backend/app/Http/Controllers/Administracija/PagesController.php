<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Settings\SiteSettings;
use App\Support\BlockSchema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PagesController extends Controller
{
    public function index(): Response
    {
        $stranice = Page::orderBy('sort')->orderBy('id')->get()
            ->map(fn (Page $p) => $this->row($p))
            ->all();

        return Inertia::render('Stranice/Lista', [
            'stranice' => $stranice,
        ]);
    }

    public function show(Page $page): Response
    {
        return Inertia::render('Stranice/Builder', [
            'stranica' => [
                'id' => $page->id,
                'title' => $page->getTranslations('title'),
                'slug' => $page->slugFor('sr'),
                'url' => $page->pathFor('sr'),
                'published' => (bool) $page->published,
                'isSystem' => (bool) $page->is_system,
                'slugLocked' => $page->isHome(),
                'metaTitle' => $page->getTranslations('meta_title'),
                'metaDescription' => $page->getTranslations('meta_description'),
                'ogImage' => $page->og_image,
                'blocks' => is_array($page->content) ? $page->content : [],
            ],
            'siteName' => rescue(fn () => app(SiteSettings::class)->brand_naziv, [], false),
            'schema' => BlockSchema::all(),
            'katalog' => BlockSchema::catalog(),
            'defaults' => collect(BlockSchema::all())->keys()
                ->mapWithKeys(fn ($t) => [$t => BlockSchema::defaults($t)])
                ->all(),
        ]);
    }

    public function updateContent(Request $request, Page $page): RedirectResponse
    {
        $page->content = $this->cleanBlocks($request);
        $page->save();

        $request->session()->forget('page_draft_'.$page->id);

        return back(303)->with('status', 'Sadržaj stranice je sačuvan.');
    }

    public function draft(Request $request, Page $page): \Illuminate\Http\Response
    {
        $request->session()->put('page_draft_'.$page->id, $this->cleanBlocks($request));

        return response()->noContent();
    }

    protected function cleanBlocks(Request $request): array
    {
        $data = $request->validate([
            'blocks' => ['present', 'array'],
        ]);

        $tipovi = array_keys(BlockSchema::all());

        return collect($data['blocks'])
            ->filter(fn ($b) => is_array($b) && in_array($b['type'] ?? null, $tipovi, true))
            ->map(fn ($b) => ['type' => $b['type'], 'data' => is_array($b['data'] ?? null) ? $b['data'] : []])
            ->values()
            ->all();
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'array'],
            'title.sr' => ['required', 'string', 'max:255'],
            'title.*' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9\-]+$/'],
            'published' => ['boolean'],
        ]);

        $page = new Page();
        $page->setTranslations('title', $this->mapa($data['title']));
        $page->slug = ['sr' => ($data['slug'] ?? null) ?: Str::slug($data['title']['sr'])];
        $page->published = (bool) ($data['published'] ?? false);
        $page->is_system = false;
        $page->content = [];
        $page->setTranslations('meta_title', []);
        $page->setTranslations('meta_description', []);
        $page->sort = (int) Page::max('sort') + 1;
        $page->save();

        return back(303)->with('status', 'Stranica „'.$data['title']['sr'].'" je kreirana.');
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'array'],
            'title.sr' => ['required', 'string', 'max:255'],
            'title.*' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9\-]+$/'],
            'published' => ['boolean'],
            'meta_title' => ['array'],
            'meta_title.*' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['array'],
            'meta_description.*' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'string', 'max:2048'],
        ]);

        $page->setTranslations('title', $this->mapa($data['title']));

        if (! $page->isHome()) {
            $page->slug = array_merge((array) $page->slug, ['sr' => $data['slug']]);
        }

        $page->published = (bool) ($data['published'] ?? false);
        $page->setTranslations('meta_title', $this->mapa($data['meta_title'] ?? []));
        $page->setTranslations('meta_description', $this->mapa($data['meta_description'] ?? []));

        if ($request->exists('og_image')) {
            $page->og_image = ($data['og_image'] ?? null) ?: null;
        }

        $page->save();

        return back(303)->with('status', 'Stranica je sačuvana.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->is_system) {
            return back(303)->with('error', 'Sistemska stranica se ne može obrisati.');
        }

        $page->delete();

        return back(303)->with('status', 'Stranica je obrisana.');
    }

    protected function row(Page $page): array
    {
        $content = $page->content ?? [];

        return [
            'id' => $page->id,
            'title' => $page->getTranslations('title')['sr'] ?? '(bez naslova)',
            'titleTranslations' => $page->getTranslations('title'),
            'slug' => $page->slugFor('sr'),
            'url' => $page->pathFor('sr'),
            'published' => (bool) $page->published,
            'isSystem' => (bool) $page->is_system,
            'slugLocked' => $page->isHome(),
            'blokova' => is_array($content) ? count($content) : 0,
            'izmijenjeno' => $page->updated_at?->diffForHumans(),
            'metaTitleTranslations' => $page->getTranslations('meta_title'),
            'metaDescriptionTranslations' => $page->getTranslations('meta_description'),
        ];
    }

    protected function mapa(array $vrijednosti): array
    {
        return collect($vrijednosti)
            ->map(fn ($v) => trim((string) $v))
            ->filter(fn ($v) => $v !== '')
            ->all();
    }
}
