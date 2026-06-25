<?php

namespace App\Filament\Widgets;

use App\Enums\ContentStatus;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\News;
use App\Models\Story;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AtAGlanceWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $naOdobrenju = collect([Business::class, Location::class, Event::class, Ad::class, Story::class, News::class])
            ->sum(fn (string $model) => $model::where('status', ContentStatus::Poslano)->count());

        return [
            Stat::make('Biznisi', Business::count())
                ->description('Ukupno registrovanih biznisa')
                ->descriptionIcon('heroicon-o-building-storefront')
                ->color('primary'),
            Stat::make('Lokaliteti', Location::count())
                ->description('Ukupno lokaliteta')
                ->descriptionIcon('heroicon-o-map-pin')
                ->color('primary'),
            Stat::make('Događaji', Event::count())
                ->description('Ukupno događaja')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('primary'),
            Stat::make('Oglasi', Ad::count())
                ->description('Ukupno oglasa')
                ->descriptionIcon('heroicon-o-megaphone')
                ->color('primary'),
            Stat::make('Priče', Story::count())
                ->description('Ukupno priča')
                ->descriptionIcon('heroicon-o-book-open')
                ->color('primary'),
            Stat::make('Korisnici', User::count())
                ->description('Ukupno korisnika')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Na odobrenju', $naOdobrenju)
                ->description('Sadržaj koji čeka pregled')
                ->descriptionIcon('heroicon-o-clock')
                ->color($naOdobrenju > 0 ? 'warning' : 'gray'),
        ];
    }
}
