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

class ApprovalStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $naOdobrenju = collect([Business::class, Location::class, Event::class, Ad::class, Story::class, News::class])
            ->sum(fn (string $model) => $model::where('status', ContentStatus::Poslano)->count());

        return [
            Stat::make('Sadržaj na odobrenju', $naOdobrenju)
                ->description('Čeka pregled administratora')
                ->descriptionIcon('heroicon-o-inbox-arrow-down')
                ->color($naOdobrenju > 0 ? 'warning' : 'gray'),
            Stat::make('Nalozi na odobrenju', User::where('status', 'na_odobrenju')->count())
                ->description('Nove registracije')
                ->color('info'),
            Stat::make('Aktivni oglasi', Ad::where('status', ContentStatus::Objavljeno)->count())
                ->color('success'),
            Stat::make('Nadolazeći događaji', Event::where('status', ContentStatus::Objavljeno)->whereDate('datum', '>=', today())->count())
                ->color('success'),
        ];
    }
}
