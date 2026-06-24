<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Home'))->name('home');

Route::get('/domace-je-najbolje', [BusinessController::class, 'index'])->name('biznisi.index');
Route::get('/domace-je-najbolje/{slug}', [BusinessController::class, 'show'])->name('biznisi.show');

Route::get('/turizam', [LocationController::class, 'index'])->name('lokaliteti.index');
Route::get('/turizam/{slug}', [LocationController::class, 'show'])->name('lokaliteti.show');

Route::get('/dogadjaji', [EventController::class, 'index'])->name('dogadjaji.index');
Route::get('/dogadjaji/{slug}', [EventController::class, 'show'])->name('dogadjaji.show');

Route::get('/oglasi', [AdController::class, 'index'])->name('oglasi.index');
Route::get('/oglasi/{slug}', [AdController::class, 'show'])->name('oglasi.show');

Route::get('/price', [StoryController::class, 'index'])->name('price.index');
Route::get('/price/{slug}', [StoryController::class, 'show'])->name('price.show');

Route::get('/mapa', [MapController::class, 'index'])->name('mapa.index');
