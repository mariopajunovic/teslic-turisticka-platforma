<?php

use App\Http\Resources\AdResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\StoryResource;
use App\Http\Controllers\AdController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\StoryController;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\Story;

return [
    'types' => [
        'business' => [
            'label' => 'Biznisi',
            'model' => Business::class,
            'controller' => BusinessController::class,
            'resource' => BusinessResource::class,
            'category_type' => 'domace',
            'segment' => ['sr' => 'biznis', 'en' => 'business', 'de' => 'unternehmen'],
        ],
        'location' => [
            'label' => 'Lokaliteti',
            'model' => Location::class,
            'controller' => LocationController::class,
            'resource' => LocationResource::class,
            'category_type' => 'turizam',
            'segment' => ['sr' => 'lokalitet', 'en' => 'location', 'de' => 'ort'],
        ],
        'event' => [
            'label' => 'Događaji',
            'model' => Event::class,
            'controller' => EventController::class,
            'resource' => EventResource::class,
            'category_type' => 'dogadjaj',
            'segment' => ['sr' => 'dogadjaj', 'en' => 'event', 'de' => 'veranstaltung'],
        ],
        'ad' => [
            'label' => 'Oglasi',
            'model' => Ad::class,
            'controller' => AdController::class,
            'resource' => AdResource::class,
            'category_type' => 'oglasi',
            'segment' => ['sr' => 'oglas', 'en' => 'ad', 'de' => 'anzeige'],
        ],
        'story' => [
            'label' => 'Priče',
            'model' => Story::class,
            'controller' => StoryController::class,
            'resource' => StoryResource::class,
            'category_type' => 'price',
            'segment' => ['sr' => 'prica', 'en' => 'story', 'de' => 'geschichte'],
        ],
    ],
];
