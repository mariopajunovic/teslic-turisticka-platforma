<x-filament-panels::page>
    @php($stavke = $this->getStavke())

    <x-filament::section>
        <x-slot name="heading">
            Sadržaj na odobrenju ({{ count($stavke) }})
        </x-slot>
        <x-slot name="description">
            Sve poslano na pregled. Otvorite stavku da je odobrite, vratite na doradu ili odbijete.
        </x-slot>

        @if (count($stavke))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 pr-4 font-medium">Tip</th>
                            <th class="py-2 pr-4 font-medium">Naslov</th>
                            <th class="py-2 pr-4 font-medium">Vlasnik</th>
                            <th class="py-2 pr-4 font-medium">Poslano</th>
                            <th class="py-2 pr-4 font-medium"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                        @foreach ($stavke as $s)
                            <tr>
                                <td class="py-2 pr-4">
                                    <x-filament::badge color="warning">{{ $s['tip'] }}</x-filament::badge>
                                </td>
                                <td class="py-2 pr-4 font-medium">{{ $s['naslov'] }}</td>
                                <td class="py-2 pr-4 text-gray-500">{{ $s['vlasnik'] }}</td>
                                <td class="py-2 pr-4 text-gray-500">{{ $s['kada'] }}</td>
                                <td class="py-2 pr-4 text-right">
                                    <x-filament::button tag="a" :href="$s['url']" size="sm" icon="heroicon-o-arrow-right">
                                        Otvori
                                    </x-filament::button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-500">Nema sadržaja na odobravanju.</p>
        @endif
    </x-filament::section>
</x-filament-panels::page>
