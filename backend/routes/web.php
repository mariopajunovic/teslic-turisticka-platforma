<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Nalog\AutorStoryController;
use App\Http\Controllers\Nalog\BiznisAdController;
use App\Http\Controllers\Nalog\BiznisObjaveController;
use App\Http\Controllers\Nalog\BiznisProfilController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/domace-je-najbolje', [BusinessController::class, 'index'])->name('biznisi.index');
Route::get('/domace-je-najbolje/kategorija/{kategorija}', [BusinessController::class, 'kategorija'])->name('biznisi.kategorija');
Route::get('/domace-je-najbolje/{slug}', [BusinessController::class, 'show'])->name('biznisi.show');
Route::post('/domace-je-najbolje/{slug}/upit', [\App\Http\Controllers\BusinessInquiryController::class, 'send'])->middleware('throttle:5,1')->name('biznisi.upit');

Route::get('/turizam', [LocationController::class, 'index'])->name('lokaliteti.index');
Route::get('/turizam/kategorija/{kategorija}', [LocationController::class, 'kategorija'])->name('lokaliteti.kategorija');
Route::get('/turizam/{slug}', [LocationController::class, 'show'])->name('lokaliteti.show');

Route::get('/dogadjaji', [EventController::class, 'index'])->name('dogadjaji.index');
Route::get('/dogadjaji/{slug}', [EventController::class, 'show'])->name('dogadjaji.show');

Route::get('/oglasi', [AdController::class, 'index'])->name('oglasi.index');
Route::get('/oglasi/{slug}', [AdController::class, 'show'])->name('oglasi.show');

Route::get('/price', [StoryController::class, 'index'])->name('price.index');
Route::get('/price/kategorija/{kategorija}', [StoryController::class, 'kategorija'])->name('price.kategorija');
Route::get('/price/{slug}', [StoryController::class, 'show'])->name('price.show');

Route::get('/mapa', [MapController::class, 'index'])->name('mapa.index');

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots']);

Route::get('/kontakt', fn () => Inertia::render('Contact', ['seo' => \App\Support\Seo::make('Kontakt', 'Stupite u kontakt s nama — tu smo za sva pitanja i prijedloge.', url('/kontakt'))]))->name('kontakt');
Route::post('/kontakt', [\App\Http\Controllers\ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('kontakt.send');
Route::get('/pridruzi-se', fn () => app(PageController::class)->show('pridruzi-se'))->name('pridruzi-se');
Route::get('/pridruzi-se/biznis', fn () => Inertia::render('RegisterBusiness', ['seo' => \App\Support\Seo::make('Registruj biznis', 'Registrujte vaš lokalni biznis i budite vidljivi na teslićkom portalu.', url('/pridruzi-se/biznis'))]))->name('pridruzi-se.biznis');
Route::get('/pridruzi-se/autor', fn () => Inertia::render('RegisterAuthor', ['seo' => \App\Support\Seo::make('Uključi se kao autor', 'Pridružite se kao autor i dijelite priče s Teslića s cijelim svijetom.', url('/pridruzi-se/autor'))]))->name('pridruzi-se.autor');
Route::get('/prijava', fn () => Inertia::render('Login', ['seo' => \App\Support\Seo::make('Prijava', 'Prijavite se na svoj nalog na teslićkom portalu.', url('/prijava'))]))->name('prijava');
Route::get('/registracija', fn () => Inertia::render('RegisterChoice', ['seo' => \App\Support\Seo::make('Registracija', 'Kreirajte nalog i priključite se teslićkoj online zajednici.', url('/registracija'))]))->name('registracija');
Route::get('/zaboravljena-lozinka', fn () => Inertia::render('ForgotPassword', ['seo' => \App\Support\Seo::make('Zaboravljena lozinka', 'Resetujte svoju lozinku i povratite pristup nalogu.', url('/zaboravljena-lozinka'))]))->name('zaboravljena-lozinka');

Route::middleware('auth')->prefix('nalog')->group(function () {
    Route::middleware('role:autor')->group(function () {
        Route::get('autor/price', [AutorStoryController::class, 'index'])->name('nalog.autor.price');
        Route::get('autor/nova-prica', [AutorStoryController::class, 'create'])->name('nalog.autor.nova-prica');
        Route::post('autor/price', [AutorStoryController::class, 'store']);
        Route::get('autor/price/{story}/uredi', [AutorStoryController::class, 'edit'])->name('nalog.autor.uredi');
        Route::put('autor/price/{story}', [AutorStoryController::class, 'update']);
        Route::get('autor/profil', [\App\Http\Controllers\Nalog\AutorProfilController::class, 'edit'])->name('nalog.autor.profil');
        Route::post('autor/profil', [\App\Http\Controllers\Nalog\AutorProfilController::class, 'update']);
        Route::get('autor/postavke', fn () => Inertia::render('account/AutorPostavke'))->name('nalog.autor.postavke');
    });

    Route::middleware('role:biznis')->group(function () {
        Route::get('biznis/profil', [BiznisProfilController::class, 'edit'])->name('nalog.biznis.profil');
        Route::post('biznis/profil', [BiznisProfilController::class, 'update']);

        Route::get('biznis/objave', [BiznisObjaveController::class, 'index'])->name('nalog.biznis.objave');
        Route::get('biznis/objave/nova', [BiznisObjaveController::class, 'create'])->name('nalog.biznis.objave.nova');
        Route::post('biznis/objave', [BiznisObjaveController::class, 'store']);
        Route::get('biznis/objave/{business}/uredi', [BiznisObjaveController::class, 'edit'])->name('nalog.biznis.objave.uredi');
        Route::post('biznis/objave/{business}', [BiznisObjaveController::class, 'update']);
        Route::delete('biznis/objave/medij/{media}', [BiznisObjaveController::class, 'destroyMedia']);

        Route::get('biznis/oglasi', [BiznisAdController::class, 'index'])->name('nalog.biznis.oglasi');
        Route::get('biznis/oglasi/novi', [BiznisAdController::class, 'create'])->name('nalog.biznis.oglasi.novi');
        Route::post('biznis/oglasi', [BiznisAdController::class, 'store']);
        Route::get('biznis/oglasi/{ad}/uredi', [BiznisAdController::class, 'edit'])->name('nalog.biznis.oglasi.uredi');
        Route::put('biznis/oglasi/{ad}', [BiznisAdController::class, 'update']);

        Route::get('biznis/postavke', fn () => Inertia::render('account/BiznisPostavke'))->name('nalog.biznis.postavke');
    });
});

Route::get('/o-projektu', [PageController::class, 'about'])->name('o-projektu');

Route::post('/odrzavanje/otkljucaj', [MaintenanceController::class, 'unlock'])->name('odrzavanje.otkljucaj');

Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '(?!admin$|build$|storage$)[a-z0-9\-]+')
    ->name('pages.show');
