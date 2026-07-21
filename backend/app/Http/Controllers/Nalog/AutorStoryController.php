<?php

namespace App\Http\Controllers\Nalog;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoryRequest;
use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AutorStoryController extends Controller
{
    public function index(): Response
    {
        $price = Story::where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(fn (Story $s) => [
                'id' => $s->id,
                'naslov' => $s->naslov,
                'meta' => $s->status->getLabel().' · '.($s->datum?->format('d.m.Y.') ?? ''),
                'status' => $s->status->badge(),
                'reason' => $s->status === ContentStatus::Odbijeno ? $s->rejection_reason : null,
                'editUrl' => "/nalog/autor/price/{$s->id}/uredi",
            ]);

        return Inertia::render('account/AutorPrice', ['price' => $price]);
    }

    public function pregled(): Response
    {
        $price = Story::where('user_id', auth()->id())->get();

        return Inertia::render('account/AutorPregled', [
            'korisnik' => auth()->user()->name,
            'stats' => [
                'ukupno' => $price->count(),
                'objavljeno' => $price->where('status', ContentStatus::Objavljeno)->count(),
                'naCekanju' => $price->where('status', ContentStatus::Poslano)->count(),
                'nacrt' => $price->where('status', ContentStatus::Nacrt)->count(),
                'odbijeno' => $price->where('status', ContentStatus::Odbijeno)->count(),
            ],
            'odbijeni' => $price->where('status', ContentStatus::Odbijeno)->map(fn (Story $s) => [
                'naslov' => $s->naslov,
                'razlog' => $s->rejection_reason,
                'editUrl' => "/nalog/autor/price/{$s->id}/uredi",
            ])->values()->all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('account/AutorNovaPrica', [
            'story' => null,
            'kategorije' => $this->categories(),
        ]);
    }

    public function edit(Story $story): Response
    {
        $this->authorizeOwner($story);

        $data = $story->pending ?? [
            'naslov' => $story->naslov,
            'category_id' => $story->category_id,
            'izvod' => $story->izvod,
            'sadrzaj' => $story->sadrzaj,
        ];

        return Inertia::render('account/AutorNovaPrica', [
            'story' => array_merge($data, [
                'id' => $story->id,
                'objavljeno' => $story->status === ContentStatus::Objavljeno,
                'imaPending' => $story->pending !== null,
            ]),
            'kategorije' => $this->categories(),
        ]);
    }

    public function store(StoryRequest $request): RedirectResponse
    {
        $story = new Story(['user_id' => auth()->id(), 'autor' => auth()->user()->name]);
        $this->fill($story, $request);

        return redirect('/nalog/autor/price')->with('status', $this->message($story));
    }

    public function update(StoryRequest $request, Story $story): RedirectResponse
    {
        $this->authorizeOwner($story);
        $this->fill($story, $request);

        return redirect('/nalog/autor/price')->with('status', $this->message($story));
    }

    protected function fill(Story $story, StoryRequest $request): void
    {
        $data = $request->validated();

        // Izmjena već objavljene priče -> ide na moderaciju; živa verzija ostaje aktivna.
        if ($story->exists && $story->status === ContentStatus::Objavljeno) {
            $story->pending = $this->pendingPayload($data);
            $story->save();

            return;
        }

        $story->popuniIz($data);
        $story->status = $data['action'] === 'posalji' ? ContentStatus::Poslano : ContentStatus::Nacrt;

        if (! $story->datum) {
            $story->datum = now();
        }

        $story->save();
    }

    protected function pendingPayload(array $data): array
    {
        return collect($data)->only(['naslov', 'category_id', 'izvod', 'sadrzaj'])->all();
    }

    protected function message(Story $story): string
    {
        if ($story->pending !== null) {
            return 'Izmjene su poslane na odobrenje. Trenutna priča ostaje objavljena.';
        }

        return $story->status === ContentStatus::Poslano
            ? 'Priča je poslana na odobrenje.'
            : 'Priča je sačuvana kao nacrt.';
    }

    protected function categories(): array
    {
        return Category::where('type', 'price')
            ->orderBy('label')
            ->get()
            ->map(fn (Category $c) => ['value' => $c->id, 'label' => $c->label])
            ->all();
    }

    protected function authorizeOwner(Story $story): void
    {
        abort_unless($story->user_id === auth()->id(), 403);
    }
}
