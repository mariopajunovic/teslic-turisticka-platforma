<?php

namespace App\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static ?int $sort = -1;

    protected string $view = 'filament.widgets.welcome';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'ime' => Filament::auth()->user()?->name ?? 'administratore',
        ];
    }
}
