<?php

namespace App\Http\Controllers\Nalog;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\BiznisDogadjajRequest;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BiznisDogadjajController extends Controller
{
    public function index(): Response
    {
        $dogadjaji = Event::where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(fn (Event $e) => [
                'id' => $e->id,
                'naslov' => $e->naslov,
                'meta' => $e->status->getLabel().($e->datum ? ' · '.$e->datum->format('d.m.Y.') : ''),
                'status' => $e->status->badge(),
                'reason' => $e->status === ContentStatus::Odbijeno ? $e->rejection_reason : null,
                'editUrl' => "/nalog/biznis/dogadjaji/{$e->id}/uredi",
            ]);

        return Inertia::render('account/BiznisDogadjaji', ['dogadjaji' => $dogadjaji]);
    }

    public function create(): Response
    {
        return Inertia::render('account/BiznisDogadjajForm', [
            'dogadjaj' => null,
            'vrste' => $this->vrste(),
        ]);
    }

    public function edit(Event $event): Response
    {
        $this->authorizeOwner($event);

        return Inertia::render('account/BiznisDogadjajForm', [
            'dogadjaj' => [
                'id' => $event->id,
                'naslov' => $event->naslov,
                'category_id' => $event->category_id,
                'datum' => $event->datum?->format('Y-m-d'),
                'vrijeme' => $event->vrijeme,
                'lokacija' => $event->lokacija,
                'organizator' => $event->organizator,
                'opis_dug' => $event->opis_dug,
            ],
            'vrste' => $this->vrste(),
        ]);
    }

    public function store(BiznisDogadjajRequest $request): RedirectResponse
    {
        $event = new Event(['user_id' => auth()->id()]);
        $this->fill($event, $request);

        return $this->done($event);
    }

    public function update(BiznisDogadjajRequest $request, Event $event): RedirectResponse
    {
        $this->authorizeOwner($event);
        $this->fill($event, $request);

        return $this->done($event);
    }

    protected function fill(Event $event, BiznisDogadjajRequest $request): void
    {
        $data = $request->validated();

        $event->fill([
            'naslov' => $data['naslov'],
            'category_id' => $data['category_id'] ?? null,
            'datum' => $data['datum'],
            'vrijeme' => $data['vrijeme'] ?? null,
            'lokacija' => $data['lokacija'] ?? null,
            'organizator' => $data['organizator'] ?? null,
            'opis_dug' => $data['opis_dug'] ?? null,
            'status' => $data['action'] === 'posalji' ? ContentStatus::Poslano : ContentStatus::Nacrt,
        ]);
        $event->save();

        if ($event->status === ContentStatus::Poslano) {
            \App\Support\OrgNotifier::send(new \App\Notifications\OrgSadrzajNaOdobrenju(
                'Događaj',
                (string) $event->naslov,
                (string) (auth()->user()->name ?? ''),
                false,
            ));
        }
    }

    protected function done(Event $event): RedirectResponse
    {
        return redirect('/nalog/biznis/dogadjaji')->with(
            'status',
            $event->status === ContentStatus::Poslano ? 'Događaj je poslan na odobrenje.' : 'Događaj je sačuvan kao nacrt.'
        );
    }

    protected function vrste(): array
    {
        return Category::where('type', 'dogadjaj')
            ->orderBy('label')
            ->get()
            ->map(fn (Category $c) => ['value' => $c->id, 'label' => $c->label])
            ->all();
    }

    protected function authorizeOwner(Event $event): void
    {
        abort_unless($event->user_id === auth()->id(), 403);
    }
}
