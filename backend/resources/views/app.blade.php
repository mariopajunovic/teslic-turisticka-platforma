<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0E8275">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <meta name="apple-mobile-web-app-title" content="TO Teslić">
    <link rel="manifest" href="/site.webmanifest">
    @php
        $props = $page['props'] ?? [];
        $seo = $props['seo'] ?? [];
        $postavke = $props['site']['postavke'] ?? [];
        $apsolutni = fn ($url) => $url
            ? (\Illuminate\Support\Str::startsWith($url, ['http://', 'https://']) ? $url : url($url))
            : null;
        $brandNaziv = ($postavke['brandNaziv'] ?? null) ?: 'TO Teslić';
        $metaNaslov = ($seo['title'] ?? null) ? $seo['title'].' - '.$brandNaziv : $brandNaziv;
        $metaOpis = $seo['description']
            ?? (($postavke['seoOpis'] ?? null) ?: 'Digitalna platforma za promociju turizma, domaćih proizvoda i usluga opštine Teslić.');
        $metaUrl = $apsolutni($seo['canonical'] ?? url()->current());
        $metaSlika = $apsolutni($seo['image'] ?? ($postavke['ogDefaultImage'] ?? null));
        $metaTip = $seo['type'] ?? 'website';
        $metaRoboti = ($postavke['indeksiranje'] ?? true) === false ? 'noindex, nofollow' : 'index, follow';
    @endphp
    <meta property="og:site_name" content="{{ $brandNaziv }}">
    <meta property="og:locale" content="{{ $props['locale']['ogLocale'] ?? 'sr_RS' }}" data-inertia="og:locale">
    <meta name="robots" content="{{ $metaRoboti }}" data-inertia="robots">
    <meta name="description" content="{{ $metaOpis }}" data-inertia="description">
    <link rel="canonical" href="{{ $metaUrl }}" data-inertia="canonical">
    <meta property="og:title" content="{{ $metaNaslov }}" data-inertia="og:title">
    <meta property="og:description" content="{{ $metaOpis }}" data-inertia="og:description">
    <meta property="og:type" content="{{ $metaTip }}" data-inertia="og:type">
    <meta property="og:url" content="{{ $metaUrl }}" data-inertia="og:url">
    @if ($metaSlika)
        <meta property="og:image" content="{{ $metaSlika }}" data-inertia="og:image">
        <meta name="twitter:image" content="{{ $metaSlika }}" data-inertia="twitter:image">
    @endif
    <meta name="twitter:card" content="{{ $metaSlika ? 'summary_large_image' : 'summary' }}" data-inertia="twitter:card">
    <title inertia>{{ $metaNaslov }}</title>
    @php($ga = trim((string) app(\App\Settings\SiteSettings::class)->google_analytics))
    @if ($ga !== '')
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($ga) }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', @js($ga));
        </script>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
