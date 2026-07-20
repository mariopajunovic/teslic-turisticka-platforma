<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\Nalog\AutorStoryController;
use App\Http\Controllers\Nalog\BiznisAdController;
use App\Http\Controllers\Nalog\BiznisObjaveController;
use App\Http\Controllers\Nalog\BiznisProfilController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

$detailSegments = collect((array) config('resources.types'))
    ->flatMap(fn ($cfg) => array_values((array) ($cfg['segment'] ?? [])))
    ->filter()
    ->unique()
    ->all();

$reservedSegments = array_merge(
    ['admin', 'build', 'storage', 'administracija', 'pismo', 'reset-lozinke', 'odrzavanje', 'robots', 'sitemap', 'nalog', 'vijesti', 'javne-nabavke'],
    (array) config('locales.prefixed'),
    $detailSegments,
);
$slugPattern = '(?!(?:'.implode('|', $reservedSegments).')$)[a-z0-9\-]+';
$parentPattern = '(?!(?:'.implode('|', $reservedSegments).')(?:/|$))[a-z0-9\-]+';

$public = function (string $lang) use ($slugPattern, $parentPattern) {
    Route::get('/', [PageController::class, 'home'])->name('home');

    foreach ((array) config('resources.types') as $tip => $cfg) {
        $segment = $cfg['segment'][$lang] ?? $cfg['segment']['sr'] ?? $tip;

        Route::get('/'.$segment.'/{slug}', [$cfg['controller'], 'show'])->name($tip.'.show');
    }

    Route::post('/'.(config('resources.types.business.segment')[$lang] ?? 'biznis').'/{slug}/upit', [\App\Http\Controllers\BusinessInquiryController::class, 'send'])
        ->middleware('throttle:5,1')
        ->name('biznisi.upit');

    Route::get('/mapa', [MapController::class, 'index'])->name('mapa.index');

    Route::get('/vijesti', [NewsController::class, 'index'])->name('vijesti');
    Route::get('/javne-nabavke', [ProcurementController::class, 'index'])->name('javne-nabavke');

    Route::get('/kontakt', fn () => Inertia::render('Contact', ['seo' => \App\Support\Seo::make('Kontakt', 'Stupite u kontakt s nama — tu smo za sva pitanja i prijedloge.', url()->current())]))->name('kontakt');
    Route::post('/kontakt', [\App\Http\Controllers\ContactController::class, 'send'])
        ->middleware('throttle:5,1')
        ->name('kontakt.send');
    Route::get('/pridruzi-se', fn () => app(PageController::class)->show('pridruzi-se'))->name('pridruzi-se');
    Route::get('/pridruzi-se/biznis', fn () => Inertia::render('RegisterBusiness', ['seo' => \App\Support\Seo::make('Registruj biznis', 'Registrujte vaš lokalni biznis i budite vidljivi na teslićkom portalu.', url()->current())]))->name('pridruzi-se.biznis');
    Route::get('/pridruzi-se/autor', fn () => Inertia::render('RegisterAuthor', ['seo' => \App\Support\Seo::make('Uključi se kao autor', 'Pridružite se kao autor i dijelite priče s Teslića s cijelim svijetom.', url()->current())]))->name('pridruzi-se.autor');
    Route::get('/prijava', fn () => Inertia::render('Login', ['seo' => \App\Support\Seo::make('Prijava', 'Prijavite se na svoj nalog na teslićkom portalu.', url()->current())]))->name('prijava');
    Route::get('/registracija', fn () => Inertia::render('RegisterChoice', ['seo' => \App\Support\Seo::make('Registracija', 'Kreirajte nalog i priključite se teslićkoj online zajednici.', url()->current())]))->name('registracija');
    Route::get('/zaboravljena-lozinka', fn () => Inertia::render('ForgotPassword', ['seo' => \App\Support\Seo::make('Zaboravljena lozinka', 'Resetujte svoju lozinku i povratite pristup nalogu.', url()->current())]))->name('zaboravljena-lozinka');

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

    Route::get('/{slug}', [PageController::class, 'show'])
        ->where('slug', $slugPattern)
        ->name('pages.show');

    Route::get('/{parent}/{slug}', [PageController::class, 'child'])
        ->where('parent', $parentPattern)
        ->where('slug', $slugPattern)
        ->name('pages.child');
};

// Serbian (default language, no URL prefix).
Route::group([], fn () => $public('sr'));

// Prefixed languages (/en, /de).
foreach ((array) config('locales.prefixed') as $prefix) {
    Route::prefix($prefix)->name($prefix.'.')->group(fn () => $public($prefix));
}

// Script toggle (Latin / Cyrillic) for Serbian — cookie based, same URL.
Route::get('/pismo/{script}', function (string $script) {
    $script = $script === 'cir' ? 'cir' : 'lat';

    return redirect()->back()->withCookie(cookie('pismo', $script, 60 * 24 * 365));
})->where('script', 'lat|cir')->name('pismo.switch');

// Admin content edit-locale switch (Filament topbar).
Route::get('/admin/jezik/{locale}', function (string $locale) {
    if (in_array($locale, (array) config('locales.content'), true)) {
        session()->put('filament_locale', $locale);
    }

    return redirect()->back();
})->middleware('auth:admin')->name('admin.content-locale');

Route::get('/reset-lozinke/{token}', function (string $token) {
    return Inertia::render('ResetPassword', [
        'token' => $token,
        'email' => (string) request('email'),
        'seo' => \App\Support\Seo::make('Nova lozinka', 'Postavite novu lozinku za svoj nalog.', url()->current()),
    ]);
})->middleware('guest')->name('password.reset');

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots']);

Route::post('/odrzavanje/otkljucaj', [MaintenanceController::class, 'unlock'])->name('odrzavanje.otkljucaj');
