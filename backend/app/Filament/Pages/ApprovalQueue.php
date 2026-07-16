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
use App\Services\ContentWorkflow;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class ApprovalQueue extends Page
{
    protected string $view = 'filament.pages.approval-queue';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'Sadržaj';

    protected static ?int $navigationSort = -1;

    public ?string $filterTip = null;

    public static function getNavigationLabel(): string
    {
        return 'Red odobravanja';
    }

    public function getTitle(): string
    {
        return 'Red odobravanja';
    }

    public static function getNavigationBadge(): ?string
    {
        $broj = static::totalPending();

        return $broj > 0 ? (string) $broj : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('upravljanje sadržajem') ?? false;
    }

    /**
     * @return array<string, array{0: class-string<Model>, 1: string, 2: string, 3: class-string}>
     */
    protected static function map(): array
    {
        return [
            'business' => [Business::class, 'Biznis', 'primary', BusinessResource::class],
            'location' => [Location::class, 'Lokalitet', 'success', LocationResource::class],
            'event' => [Event::class, 'Događaj', 'warning', EventResource::class],
            'ad' => [Ad::class, 'Oglas', 'gray', AdResource::class],
            'story' => [Story::class, 'Priča', 'info', StoryResource::class],
            'news' => [News::class, 'Vijest', 'danger', NewsResource::class],
        ];
    }

    protected static function totalPending(): int
    {
        return collect(static::map())
            ->sum(fn (array $m) => $m[0]::where('status', ContentStatus::Poslano)->count());
    }

    /**
     * @return array<string, array{label: string, color: string, count: int}>
     */
    public function getBrojaci(): array
    {
        $out = [];

        foreach (static::map() as $key => [$model, $label, $color]) {
            $out[$key] = [
                'label' => $label,
                'color' => $color,
                'count' => $model::where('status', ContentStatus::Poslano)->count(),
            ];
        }

        return $out;
    }

    public function getStavke(): array
    {
        $stavke = [];

        foreach (static::map() as $key => [$model, $label, $color, $resource]) {
            if ($this->filterTip && $this->filterTip !== $key) {
                continue;
            }

            $records = $model::where('status', ContentStatus::Poslano)
                ->with('user')
                ->oldest('updated_at')
                ->get();

            foreach ($records as $record) {
                $stavke[] = [
                    'key' => $key.':'.$record->getKey(),
                    'tip' => $label,
                    'color' => $color,
                    'naslov' => $record->naslov,
                    'kategorija' => $record->category?->label,
                    'vlasnik' => $record->user?->name ?? '—',
                    'kada' => $record->updated_at,
                    'url' => $resource::getUrl('edit', ['record' => $record]),
                ];
            }
        }

        usort($stavke, fn ($a, $b) => $a['kada'] <=> $b['kada']);

        return $stavke;
    }

    public function setFilter(?string $tip): void
    {
        $this->filterTip = $this->filterTip === $tip ? null : $tip;
    }

    protected function resolve(array $arguments): ?Model
    {
        $parts = explode(':', $arguments['key'] ?? '');

        if (count($parts) !== 2) {
            return null;
        }

        [$key, $id] = $parts;
        $model = static::map()[$key][0] ?? null;

        return $model ? $model::find($id) : null;
    }

    public function odobriAction(): Action
    {
        return Action::make('odobri')
            ->label('Odobri i objavi')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Odobri i objavi')
            ->modalDescription('Sadržaj će odmah postati vidljiv na sajtu.')
            ->modalSubmitActionLabel('Odobri')
            ->action(function (array $arguments): void {
                $record = $this->resolve($arguments);

                if (! $record) {
                    return;
                }

                app(ContentWorkflow::class)->approve($record);

                Notification::make()
                    ->success()
                    ->title('Objavljeno')
                    ->body('Sadržaj je odobren i objavljen na sajtu.')
                    ->send();
            });
    }

    public function vratiAction(): Action
    {
        return Action::make('vrati')
            ->label('Vrati na doradu')
            ->icon('heroicon-o-arrow-uturn-left')
            ->color('warning')
            ->modalHeading('Vrati na doradu')
            ->modalSubmitActionLabel('Vrati')
            ->form([
                Textarea::make('reason')
                    ->label('Razlog / napomena autoru')
                    ->required()
                    ->rows(3),
            ])
            ->action(function (array $arguments, array $data): void {
                $record = $this->resolve($arguments);

                if (! $record) {
                    return;
                }

                app(ContentWorkflow::class)->returnForRevision($record, $data['reason']);

                Notification::make()
                    ->warning()
                    ->title('Vraćeno na doradu')
                    ->body('Autor je obaviješten o potrebnim izmjenama.')
                    ->send();
            });
    }

    public function odbijAction(): Action
    {
        return Action::make('odbij')
            ->label('Odbij')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->modalHeading('Odbij sadržaj')
            ->modalSubmitActionLabel('Odbij')
            ->form([
                Textarea::make('reason')
                    ->label('Razlog odbijanja')
                    ->required()
                    ->rows(3),
            ])
            ->action(function (array $arguments, array $data): void {
                $record = $this->resolve($arguments);

                if (! $record) {
                    return;
                }

                app(ContentWorkflow::class)->reject($record, $data['reason']);

                Notification::make()
                    ->danger()
                    ->title('Odbijeno')
                    ->send();
            });
    }
}
