<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use App\Models\Translation;
use App\Support\Translations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TranslationsController extends Controller
{
    public function index(Request $request): Response
    {
        $locales = Locale::where('is_active', true)->orderBy('sort_order')->get(['code', 'name']);
        $codes = $locales->pluck('code')->all();

        $search = trim((string) $request->query('search', ''));
        $group = (string) $request->query('group', '');
        $onlyMissing = $request->boolean('missing');

        $scope = Translation::query()->when($group !== '', fn ($q) => $q->where('group', $group));

        $missingIds = $scope->clone()->get(['id', 'values'])
            ->filter(fn (Translation $t) => $this->rowMissing($t->values, $codes))
            ->pluck('id')
            ->all();

        $page = $scope->clone()
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('key', 'like', "%{$search}%")
                ->orWhere('values', 'like', "%{$search}%")))
            ->when($onlyMissing, fn ($q) => $q->whereIn('id', $missingIds))
            ->orderBy('key')
            ->paginate(10)
            ->withQueryString();

        $rows = collect($page->items())->map(fn (Translation $t) => [
            'id' => $t->id,
            'group' => $t->group,
            'key' => $t->key,
            'values' => $this->normalize($t->values, $codes),
            'missing' => $this->rowMissing($t->values, $codes),
        ])->all();

        return Inertia::render('Translations', [
            'columns' => $locales->map(fn (Locale $l) => ['code' => $l->code, 'name' => $l->name])->all(),
            'translations' => $rows,
            'groups' => Translation::query()->distinct()->orderBy('group')->pluck('group')->all(),
            'filters' => ['search' => $search, 'group' => $group, 'missing' => $onlyMissing],
            'missingCount' => count($missingIds),
            'pagination' => [
                'links' => $page->linkCollection()->toArray(),
                'meta' => ['from' => $page->firstItem(), 'to' => $page->lastItem(), 'total' => $page->total()],
            ],
        ]);
    }

    public function update(Request $request, Translation $translation): RedirectResponse
    {
        $codes = Locale::where('is_active', true)->pluck('code')->all();

        $data = $request->validate([
            'values' => ['required', 'array'],
            'values.*' => ['nullable', 'string'],
        ]);

        $incoming = array_map(fn ($v) => (string) $v, array_intersect_key($data['values'], array_flip($codes)));

        $old = (array) $translation->values;
        $new = array_merge($old, $incoming);

        $changed = array_keys(array_filter($incoming, fn ($v, $c) => (string) ($old[$c] ?? '') !== $v, ARRAY_FILTER_USE_BOTH));

        if ($changed) {
            $translation->values = $new;
            $translation->save();

            app(Translations::class)->forget();

            activity('sistem')
                ->causedBy(auth('admin')->user())
                ->event('updated')
                ->withProperties([
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'attributes' => ['key' => $translation->key] + array_intersect_key($new, array_flip($changed)),
                    'old' => array_intersect_key($old, array_flip($changed)),
                ])
                ->log('Izmijenjen prevod '.$translation->key);
        }

        return back(303);
    }

    protected function normalize($values, array $codes): array
    {
        $values = (array) $values;

        return collect($codes)->mapWithKeys(fn ($c) => [$c => (string) ($values[$c] ?? '')])->all();
    }

    protected function rowMissing($values, array $codes): bool
    {
        $values = (array) $values;

        foreach ($codes as $c) {
            if (trim((string) ($values[$c] ?? '')) === '') {
                return true;
            }
        }

        return false;
    }
}
