<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;

class Seo
{
    public static function make(
        string $title,
        ?string $description = null,
        ?string $canonical = null,
        ?string $image = null,
        string $type = 'website',
        ?array $jsonLd = null,
    ): array {
        return array_filter([
            'title' => $title,
            'description' => $description ? str($description)->limit(160)->value() : null,
            'canonical' => $canonical ?? url()->current(),
            'image' => $image ?: null,
            'type' => $type,
            'jsonLd' => $jsonLd,
        ], fn ($v) => $v !== null && $v !== '');
    }

    public static function breadcrumbs(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => url($item['url']),
            ])->all(),
        ];
    }

    public static function localBusiness(Model $business): array
    {
        $kontakt = $business->kontakt ?? [];

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $business->naslov,
            'description' => $business->opis ?: $business->opis_dug,
            'url' => url('/domace-je-najbolje/'.$business->slug),
            'telephone' => $kontakt['telefon'] ?? null,
            'email' => $kontakt['email'] ?? null,
            'address' => ($kontakt['adresa'] ?? $business->lokacija) ? [
                '@type' => 'PostalAddress',
                'streetAddress' => $kontakt['adresa'] ?? $business->lokacija,
                'addressLocality' => 'Teslić',
                'addressCountry' => 'BA',
            ] : null,
            'image' => $business->getFirstMediaUrl('naslovna') ?: null,
        ], fn ($v) => $v !== null && $v !== '');
    }

    public static function event(Model $event): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event->naslov,
            'description' => $event->opis_dug,
            'startDate' => $event->datum?->toIso8601String(),
            'url' => url('/dogadjaji/'.$event->slug),
            'location' => $event->lokacija ? [
                '@type' => 'Place',
                'name' => $event->lokacija,
                'address' => 'Teslić, BA',
            ] : null,
            'image' => $event->getFirstMediaUrl('naslovna') ?: null,
        ], fn ($v) => $v !== null && $v !== '');
    }

    public static function article(Model $story): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $story->naslov,
            'description' => $story->izvod,
            'author' => $story->autor ? ['@type' => 'Person', 'name' => $story->autor] : null,
            'datePublished' => $story->datum?->toIso8601String(),
            'url' => url('/price/'.$story->slug),
            'image' => $story->getFirstMediaUrl('naslovna') ?: null,
        ], fn ($v) => $v !== null && $v !== '');
    }
}
