<x-filament-panels::page>
    @php
        $brojaci = $this->getBrojaci();
        $stavke = $this->getStavke();
        $ukupno = collect($brojaci)->sum('count');
    @endphp

    {{-- Brojači po tipu + filter --}}
    <div class="flex flex-wrap items-center gap-2">
        <button
            type="button"
            wire:click="setFilter(null)"
            @class([
                'fi-badge inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-sm font-medium ring-1 ring-inset transition',
                'bg-primary-600 text-white ring-primary-600' => $this->filterTip === null,
                'bg-white text-gray-700 ring-gray-200 hover:bg-gray-50 dark:bg-white/5 dark:text-gray-200 dark:ring-white/10' => $this->filterTip !== null,
            ])
        >
            Sve
            <span class="rounded-full bg-black/10 px-1.5 text-xs dark:bg-white/15">{{ $ukupno }}</span>
        </button>

        @foreach ($brojaci as $key => $b)
            <button
                type="button"
                wire:click="setFilter('{{ $key }}')"
                @class([
                    'inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-sm font-medium ring-1 ring-inset transition',
                    'opacity-40' => $b['count'] === 0,
                    'bg-primary-600 text-white ring-primary-600' => $this->filterTip === $key,
                    'bg-white text-gray-700 ring-gray-200 hover:bg-gray-50 dark:bg-white/5 dark:text-gray-200 dark:ring-white/10' => $this->filterTip !== $key,
                ])
            >
                {{ $b['label'] }}
                <span class="rounded-full bg-black/10 px-1.5 text-xs dark:bg-white/15">{{ $b['count'] }}</span>
            </button>
        @endforeach
    </div>

    <x-filament::section>
        <x-slot name="heading">
            Sadržaj na odobrenju ({{ count($stavke) }})
        </x-slot>
        <x-slot name="description">
            Najstarije čeka na vrhu. Odobrite, vratite autoru na doradu ili odbijte — direktno odavde.
        </x-slot>

        @if (count($stavke))
            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-gray-500 dark:border-white/10">
                            <th class="py-2 pr-4 font-medium">Tip</th>
                            <th class="py-2 pr-4 font-medium">Naslov</th>
                            <th class="py-2 pr-4 font-medium">Autor</th>
                            <th class="whitespace-nowrap py-2 pr-4 font-medium">Čeka</th>
                            <th class="py-2 pl-4 text-right font-medium">Akcije</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                        @foreach ($stavke as $s)
                            <tr wire:key="{{ $s['key'] }}" class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="py-3 pr-4 align-middle">
                                    <x-filament::badge :color="$s['color']">{{ $s['tip'] }}</x-filament::badge>
                                </td>
                                <td class="py-3 pr-4 align-middle">
                                    <a
                                        href="{{ $s['url'] }}"
                                        class="font-medium text-gray-950 hover:text-primary-600 dark:text-white dark:hover:text-primary-400"
                                    >
                                        {{ $s['naslov'] }}
                                    </a>
                                    @if ($s['kategorija'])
                                        <div class="text-xs text-gray-500">{{ $s['kategorija'] }}</div>
                                    @endif
                                </td>
                                <td class="py-3 pr-4 align-middle text-gray-500">{{ $s['vlasnik'] }}</td>
                                <td class="whitespace-nowrap py-3 pr-4 align-middle text-gray-500">
                                    <span title="{{ $s['kada']?->format('d.m.Y. H:i') }}">
                                        {{ $s['kada']?->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="w-px whitespace-nowrap py-3 pl-4 align-middle">
                                    <div class="flex flex-nowrap items-center justify-end gap-1">
                                        <x-filament::button
                                            size="sm"
                                            color="success"
                                            icon="heroicon-o-check-circle"
                                            wire:click="mountAction('odobri', { key: '{{ $s['key'] }}' })"
                                        >
                                            Odobri
                                        </x-filament::button>

                                        <x-filament::icon-button
                                            size="lg"
                                            color="warning"
                                            icon="heroicon-o-arrow-uturn-left"
                                            tooltip="Vrati na doradu"
                                            label="Vrati na doradu"
                                            wire:click="mountAction('vrati', { key: '{{ $s['key'] }}' })"
                                        />

                                        <x-filament::icon-button
                                            size="lg"
                                            color="danger"
                                            icon="heroicon-o-x-circle"
                                            tooltip="Odbij"
                                            label="Odbij"
                                            wire:click="mountAction('odbij', { key: '{{ $s['key'] }}' })"
                                        />

                                        <x-filament::icon-button
                                            tag="a"
                                            size="lg"
                                            color="gray"
                                            icon="heroicon-o-pencil-square"
                                            tooltip="Otvori"
                                            label="Otvori"
                                            :href="$s['url']"
                                        />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center gap-2 py-10 text-center">
                <x-filament::icon icon="heroicon-o-check-badge" class="h-10 w-10 text-gray-400" />
                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Nema sadržaja na odobravanju.</p>
                <p class="text-xs text-gray-400">Sve poslano je obrađeno.</p>
            </div>
        @endif
    </x-filament::section>

    <x-filament-actions::modals />
</x-filament-panels::page>
