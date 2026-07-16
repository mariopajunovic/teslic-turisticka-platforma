@php
    $locales = (array) config('locales.content');
    $labels = (array) config('locales.admin_labels');
    $active = session('filament_locale', $locales[0]);
@endphp

<div class="flex items-center gap-1" title="Jezik unosa sadržaja">
    @foreach ($locales as $loc)
        <a
            href="{{ url('/admin/jezik/'.$loc) }}"
            class="rounded-md px-2.5 py-1 text-xs font-semibold transition
                {{ $loc === $active
                    ? 'bg-primary-600 text-white shadow-sm'
                    : 'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5' }}"
        >
            {{ strtoupper($loc) }}
        </a>
    @endforeach
</div>
