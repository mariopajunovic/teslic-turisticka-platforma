<?php

use App\Http\Resources\AdResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\StoryResource;
use App\Http\Controllers\AdController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\StoryController;
use App\Http\Resources\ProcurementResource;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\News;
use App\Models\Procurement;
use App\Models\Story;

return [
    'types' => [
        'business' => [
            'label' => 'Biznisi',
            'model' => Business::class,
            'controller' => BusinessController::class,
            'resource' => BusinessResource::class,
            'category_type' => 'domace',
            'search' => ['naslov', 'opis', 'lokacija'],
            'segment' => ['sr' => 'biznis', 'en' => 'business', 'de' => 'unternehmen'],
        ],
        'location' => [
            'label' => 'Lokaliteti',
            'model' => Location::class,
            'controller' => LocationController::class,
            'resource' => LocationResource::class,
            'category_type' => 'turizam',
            'search' => ['naslov', 'opis', 'lokacija'],
            'segment' => ['sr' => 'lokalitet', 'en' => 'location', 'de' => 'ort'],
        ],
        'event' => [
            'label' => 'Događaji',
            'model' => Event::class,
            'controller' => EventController::class,
            'resource' => EventResource::class,
            'category_type' => 'dogadjaj',
            'search' => ['naslov', 'opis', 'lokacija'],
            'segment' => ['sr' => 'dogadjaj', 'en' => 'event', 'de' => 'veranstaltung'],
        ],
        'ad' => [
            'label' => 'Oglasi',
            'model' => Ad::class,
            'controller' => AdController::class,
            'resource' => AdResource::class,
            'category_type' => 'oglasi',
            'search' => ['naslov', 'izdavac', 'lokacija'],
            'segment' => ['sr' => 'oglas', 'en' => 'ad', 'de' => 'anzeige'],
        ],
        'story' => [
            'label' => 'Priče',
            'model' => Story::class,
            'controller' => StoryController::class,
            'resource' => StoryResource::class,
            'category_type' => 'price',
            'search' => ['naslov', 'izvod'],
            'segment' => ['sr' => 'prica', 'en' => 'story', 'de' => 'geschichte'],
        ],
        'news' => [
            'label' => 'Vijesti',
            'model' => News::class,
            'controller' => NewsController::class,
            'resource' => NewsResource::class,
            'category_type' => null,
            'search' => ['naslov', 'izvod'],
            'segment' => ['sr' => 'vijest', 'en' => 'news', 'de' => 'nachricht'],
        ],
        'procurement' => [
            'label' => 'Javne nabavke',
            'model' => Procurement::class,
            'controller' => ProcurementController::class,
            'resource' => ProcurementResource::class,
            'category_type' => null,
            'search' => ['naslov', 'opis'],
            'segment' => ['sr' => 'javna-nabavka', 'en' => 'procurement', 'de' => 'ausschreibung'],
        ],
    ],
];
