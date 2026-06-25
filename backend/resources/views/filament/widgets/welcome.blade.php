<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary-500/10">
                <x-filament::icon
                    icon="heroicon-o-hand-raised"
                    class="h-6 w-6 text-primary-500"
                />
            </div>

            <div>
                <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">
                    Dobro došli, {{ $ime }}!
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Ovo je kontrolna tabla turističkog portala. Odavde upravljate biznisima,
                    lokalitetima, događajima, oglasima i pričama. Sadržaj koji čeka odobrenje
                    prikazan je u statistici ispod, a posljednje aktivnosti administratora
                    možete pratiti u tabeli.
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
