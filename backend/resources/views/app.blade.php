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
    <meta property="og:site_name" content="{{ config('app.name', 'TO Teslić') }}">
    <meta property="og:locale" content="sr_RS">
    @php($ogImage = app(\App\Settings\SiteSettings::class)->og_default_image)
    @if ($ogImage)
        @php($ogImageUrl = \Illuminate\Support\Str::startsWith($ogImage, ['http://', 'https://']) ? $ogImage : url(\Illuminate\Support\Facades\Storage::disk('public')->url($ogImage)))
        <meta property="og:image" content="{{ $ogImageUrl }}">
        <meta name="twitter:image" content="{{ $ogImageUrl }}">
        <meta name="twitter:card" content="summary_large_image">
    @endif
    <title inertia>{{ config('app.name', 'TO Teslić') }}</title>
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
