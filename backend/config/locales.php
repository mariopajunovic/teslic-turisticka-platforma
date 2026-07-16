<?php

return [
    // Content languages (spatie translatable keys). 'sr' is the default (no URL prefix).
    'content' => ['sr', 'en', 'de'],

    'default' => 'sr',

    // Languages that get a URL prefix (/en, /de). 'sr' stays unprefixed.
    'prefixed' => ['en', 'de'],

    // Language switcher metadata.
    'languages' => [
        'sr' => ['label' => 'Srpski', 'short' => 'SR', 'prefix' => '', 'html' => 'sr'],
        'en' => ['label' => 'English', 'short' => 'EN', 'prefix' => 'en', 'html' => 'en'],
        'de' => ['label' => 'Deutsch', 'short' => 'DE', 'prefix' => 'de', 'html' => 'de'],
    ],

    // Script toggle applies only to the Serbian language (cookie based, same URL).
    'scripts' => ['lat', 'cir'],

    // Maps active (language, script) to a Laravel app locale for UI translations / <html lang>.
    'app_locale' => [
        'sr' => ['lat' => 'sr_Latn', 'cir' => 'sr_Cyrl'],
        'en' => ['lat' => 'en', 'cir' => 'en'],
        'de' => ['lat' => 'de', 'cir' => 'de'],
    ],
];
