@php
    $links = [
        ['label' => 'Novi biznis', 'icon' => 'heroicon-m-building-storefront', 'url' => \App\Filament\Resources\Businesses\BusinessResource::getUrl('create')],
        ['label' => 'Novi događaj', 'icon' => 'heroicon-m-calendar-days', 'url' => \App\Filament\Resources\Events\EventResource::getUrl('create')],
        ['label' => 'Nova priča', 'icon' => 'heroicon-m-book-open', 'url' => \App\Filament\Resources\Stories\StoryResource::getUrl('create')],
        ['label' => 'Novi oglas', 'icon' => 'heroicon-m-megaphone', 'url' => \App\Filament\Resources\Ads\AdResource::getUrl('create')],
    ];
@endphp

<x-filament::dropdown placement="bottom-end" teleport>
    <x-slot name="trigger">
        <x-filament::button icon="heroicon-m-plus" size="sm" color="primary">
            Novo
        </x-filament::button>
    </x-slot>

    <x-filament::dropdown.list>
        @foreach ($links as $link)
            <x-filament::dropdown.list.item :href="$link['url']" :icon="$link['icon']" tag="a">
                {{ $link['label'] }}
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
