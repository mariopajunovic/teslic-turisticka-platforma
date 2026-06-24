<?php

namespace App\Filament\Pages;

use App\Enums\ContentStatus;
use App\Filament\Resources\Ads\AdResource;
use App\Filament\Resources\Businesses\BusinessResource;
use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Locations\LocationResource;
use App\Filament\Resources\News\NewsResource;
use App\Filament\Resources\Stories\StoryResource;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\News;
use App\Models\Story;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ApprovalQueue extends Page
{
    protected string $view = 'filament.pages.approval-queue';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'Sadržaj';

    protected static ?int $navigationSort = -1;

    public static function getNavigationLabel(): string
    {
        return 'Red odobravanja';
    }

    public function getTitle(): string
    {
        return 'Red odobravanja';
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('upravljanje sadržajem') ?? false;
    }

    public function getStavke(): array
    {
        $map = [
            [Business::class, 'Biznis', BusinessResource::class],
            [Location::class, 'Lokalitet', LocationResource::class],
            [Event::class, 'Događaj', EventResource::class],
            [Ad::class, 'Oglas', AdResource::class],
            [Story::class, 'Priča', StoryResource::class],
            [News::class, 'Vijest', NewsResource::class],
        ];

        $stavke = [];

        foreach ($map as [$model, $label, $resource]) {
            foreach ($model::where('status', ContentStatus::Poslano)->with('user')->latest()->get() as $record) {
                $stavke[] = [
                    'tip' => $label,
                    'naslov' => $record->naslov,
                    'vlasnik' => $record->user?->name ?? '—',
                    'kada' => $record->updated_at?->format('d.m.Y. H:i'),
                    'url' => $resource::getUrl('edit', ['record' => $record]),
                ];
            }
        }

        return $stavke;
    }
}
