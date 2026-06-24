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

        return Inertia::render('account/AutorNovaPrica', [
            'story' => [
                'id' => $story->id,
                'naslov' => $story->naslov,
                'category_id' => $story->category_id,
                'izvod' => $story->izvod,
                'sadrzaj' => $story->sadrzaj,
            ],
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

        $story->fill([
            'naslov' => $data['naslov'],
            'category_id' => $data['category_id'] ?? null,
            'izvod' => $data['izvod'] ?? null,
            'sadrzaj' => $data['sadrzaj'] ?? null,
            'status' => $data['action'] === 'posalji' ? ContentStatus::Poslano : ContentStatus::Nacrt,
        ]);

        if (! $story->datum) {
            $story->datum = now();
        }

        $story->save();
    }

    protected function message(Story $story): string
    {
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
