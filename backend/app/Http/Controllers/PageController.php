<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\StoryResource;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\Page;
use App\Models\Story;
use App\Support\MapPoints;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function home(): Response
    {
        $page = Page::published()->where('slug', 'pocetna')->first();

        if (! $page) {
            return Inertia::render('Home');
        }

        return $this->renderPage($page);
    }

    public function show(string $slug): Response
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return $this->renderPage($page);
    }

    protected function renderPage(Page $page): Response
    {
        $blocks = collect($page->content ?? [])->map(function (array $block) {
            $type = $block['type'] ?? null;

            if ($type === 'card_grid') {
                $block['data']['items'] = $this->cards($block['data'] ?? []);
            }

            if ($type === 'map') {
                $block['data']['items'] = MapPoints::all();
            }

            if ($type === 'featured_story') {
                $block['data']['item'] = $this->featuredStory($block['data'] ?? []);
            }

            return $block;
        })->all();

        $isHome = $page->slug === 'pocetna';
        $canonical = $isHome ? url('/') : url('/'.$page->slug);

        return Inertia::render('PageRenderer', [
            'page' => [
                'title' => $page->title,
                'slug' => $page->slug,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
            ],
            'blocks' => $blocks,
            'seo' => Seo::make(
                $page->meta_title ?: $page->title,
                $page->meta_description,
                $canonical,
                null,
                'website',
                [
                    Seo::breadcrumbs(
                        $isHome
                            ? [['name' => 'Početna', 'url' => '/']]
                            : [
                                ['name' => 'Početna', 'url' => '/'],
                                ['name' => $page->title, 'url' => '/'.$page->slug],
                            ]
                    ),
                ],
            ),
        ]);
    }

    protected function cards(array $data): array
    {
        $limit = (int) ($data['limit'] ?? 8);
        $kategorija = $data['kategorija'] ?? null;

        [$model, $resource] = match ($data['resource'] ?? 'business') {
            'location' => [Location::class, LocationResource::class],
            'event' => [Event::class, EventResource::class],
            'ad' => [Ad::class, AdResource::class],
            'story' => [Story::class, StoryResource::class],
            default => [Business::class, BusinessResource::class],
        };

        $query = $model::objavljeno()
            ->with(['category', 'media'])
            ->latest('published_at')
            ->limit($limit);

        if ($kategorija) {
            $query->whereHas('category', fn ($c) => $c->where('key', $kategorija));
        }

        return $resource::collection($query->get())->resolve();
    }

    protected function featuredStory(array $data): ?array
    {
        $query = Story::objavljeno()->with(['category', 'media']);

        if (! empty($data['slug'])) {
            $story = $query->where('slug', $data['slug'])->first();
        } else {
            $story = $query->where('featured', true)->latest('published_at')->first()
                ?? Story::objavljeno()->with(['category', 'media'])->latest('published_at')->first();
        }

        return $story ? (new StoryResource($story))->resolve() : null;
    }
}
