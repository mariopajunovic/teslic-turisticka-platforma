<?php

use App\Http\Controllers\Administracija\AdministratoriController;
use App\Http\Controllers\Administracija\AuthController;
use App\Http\Controllers\Administracija\BusinessesController;
use App\Http\Controllers\Administracija\LocationsController;
use App\Http\Controllers\Administracija\EventsController;
use App\Http\Controllers\Administracija\AdsController;
use App\Http\Controllers\Administracija\StoriesController;
use App\Http\Controllers\Administracija\NewsController;
use App\Http\Controllers\Administracija\ProcurementsController;
use App\Http\Controllers\Administracija\CategoriesController;
use App\Http\Controllers\Administracija\DashboardController;
use App\Http\Controllers\Administracija\KorisniciController;
use App\Http\Controllers\Administracija\LogoviController;
use App\Http\Controllers\Administracija\NavigacijaController;
use App\Http\Controllers\Administracija\MediaController;
use App\Http\Controllers\Administracija\LozinkaController;
use App\Http\Controllers\Administracija\LanguagesController;
use App\Http\Controllers\Administracija\Obavezni2faController;
use App\Http\Controllers\Administracija\PagesController;
use App\Http\Controllers\Administracija\PartnersController;
use App\Http\Controllers\Administracija\ProfilController;
use App\Http\Controllers\Administracija\SettingsController;
use App\Http\Controllers\Administracija\TranslationsController;
use App\Http\Controllers\Administracija\UlogeController;
use App\Http\Middleware\EnsureTwoFactor;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function () {
    Route::get('/prijava', [AuthController::class, 'showPrijava'])->name('prijava.show');
    Route::post('/prijava', [AuthController::class, 'prijava'])->name('prijava');
    Route::get('/2fa', [AuthController::class, 'show2fa'])->name('2fa.show');
    Route::post('/2fa', [AuthController::class, 'verify2fa'])->name('2fa');
    Route::get('/zaboravljena-lozinka', [LozinkaController::class, 'zaboravljena'])->name('lozinka.zaboravljena.show');
    Route::post('/zaboravljena-lozinka', [LozinkaController::class, 'posalji'])->name('lozinka.zaboravljena');
    Route::get('/lozinka/{token}', [LozinkaController::class, 'show'])->name('lozinka.show');
    Route::post('/lozinka', [LozinkaController::class, 'store'])->name('lozinka');
});

Route::middleware(['auth:admin', EnsureTwoFactor::class])->group(function () {
    Route::get('/2fa-postavljanje', [Obavezni2faController::class, 'show'])->name('2fa.postavi.show');
    Route::post('/2fa-postavljanje', [Obavezni2faController::class, 'store'])->name('2fa.postavi');

    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');
    Route::put('/profil/podaci', [ProfilController::class, 'podaci'])->name('profil.podaci');
    Route::put('/profil/lozinka', [ProfilController::class, 'lozinka'])->name('profil.lozinka');
    Route::post('/profil/2fa', [ProfilController::class, 'omoguci2fa'])->name('profil.2fa.omoguci');
    Route::post('/profil/2fa/kodovi', [ProfilController::class, 'regenerisi'])->name('profil.2fa.kodovi');
    Route::delete('/profil/2fa', [ProfilController::class, 'onemoguci2fa'])->name('profil.2fa.onemoguci');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/obavijesti', [\App\Http\Controllers\Administracija\ObavijestiController::class, 'index'])->name('obavijesti');

    Route::middleware('admin.access:upravljanje korisnicima')->group(function () {
        Route::get('/korisnici', [KorisniciController::class, 'index'])->name('korisnici');
        Route::post('/korisnici', [KorisniciController::class, 'store'])->name('korisnici.store');
        Route::get('/korisnici/{korisnik}', [KorisniciController::class, 'show'])->name('korisnici.show');
        Route::put('/korisnici/{korisnik}', [KorisniciController::class, 'update'])->name('korisnici.update');
        Route::post('/korisnici/{korisnik}/odobri', [KorisniciController::class, 'odobri'])->name('korisnici.odobri');
        Route::post('/korisnici/{korisnik}/blokiraj', [KorisniciController::class, 'blokiraj'])->name('korisnici.blokiraj');
        Route::post('/korisnici/{korisnik}/odblokiraj', [KorisniciController::class, 'odblokiraj'])->name('korisnici.odblokiraj');
        Route::post('/korisnici/{korisnik}/reset-lozinke', [KorisniciController::class, 'resetLozinke'])->name('korisnici.reset-lozinke');
        Route::post('/korisnici/{korisnik}/avatar', [KorisniciController::class, 'avatar'])->name('korisnici.avatar');
        Route::delete('/korisnici/{korisnik}/avatar', [KorisniciController::class, 'obrisiAvatar'])->name('korisnici.avatar.obrisi');
        Route::delete('/korisnici/{korisnik}', [KorisniciController::class, 'destroy'])->name('korisnici.destroy');
        Route::post('/korisnici/{korisnik}/vrati', [KorisniciController::class, 'vrati'])->withTrashed()->name('korisnici.vrati');
        Route::delete('/korisnici/{korisnik}/trajno', [KorisniciController::class, 'trajnoObrisi'])->withTrashed()->name('korisnici.trajno');
    });

    Route::middleware('admin.access:administratori')->group(function () {
        Route::get('/administratori', [AdministratoriController::class, 'index'])->name('administratori');
        Route::post('/administratori', [AdministratoriController::class, 'store'])->name('administratori.store');
        Route::put('/administratori/{administrator}', [AdministratoriController::class, 'update'])->name('administratori.update');
        Route::post('/administratori/{administrator}/reset-lozinke', [AdministratoriController::class, 'resetLozinke'])->name('administratori.reset-lozinke');
        Route::post('/administratori/{administrator}/reset-2fa', [AdministratoriController::class, 'reset2fa'])->name('administratori.reset-2fa');
        Route::post('/administratori/{administrator}/deaktiviraj', [AdministratoriController::class, 'deaktiviraj'])->name('administratori.deaktiviraj');
        Route::post('/administratori/{administrator}/aktiviraj', [AdministratoriController::class, 'aktiviraj'])->name('administratori.aktiviraj');

        Route::get('/uloge', [UlogeController::class, 'index'])->name('uloge');
        Route::post('/uloge', [UlogeController::class, 'store'])->name('uloge.store');
        Route::put('/uloge/dozvole', [UlogeController::class, 'update'])->name('uloge.dozvole');
        Route::get('/uloge/{uloga}/korisnici', [UlogeController::class, 'korisnici'])->name('uloge.korisnici');
        Route::delete('/uloge/{uloga}', [UlogeController::class, 'destroy'])->name('uloge.destroy');
    });

    Route::middleware('admin.access:upravljanje stranicama')->group(function () {
        Route::get('/stranice', [PagesController::class, 'index'])->name('pages');
        Route::post('/stranice', [PagesController::class, 'store'])->name('pages.store');
        Route::get('/stranice/{page}/uredi', [PagesController::class, 'show'])->name('pages.builder');
        Route::put('/stranice/{page}/sadrzaj', [PagesController::class, 'updateContent'])->name('pages.content');
        Route::post('/stranice/{page}/pregled-draft', [PagesController::class, 'draft'])->name('pages.draft');
        Route::post('/stranice/{page}/globalni-blok', [PagesController::class, 'storeGlobalBlok'])->name('pages.global-blok');
        Route::delete('/globalni-blokovi/{globalBlok}', [PagesController::class, 'destroyGlobalBlok'])->name('pages.global-blok.destroy');
        Route::put('/stranice/{page}', [PagesController::class, 'update'])->name('pages.update');
        Route::delete('/stranice/{page}', [PagesController::class, 'destroy'])->name('pages.destroy');
        Route::post('/mediji', [MediaController::class, 'store'])->name('media.store');
    });

    Route::middleware('admin.access:upravljanje sadržajem')->group(function () {
        Route::get('/biznisi', [BusinessesController::class, 'index'])->name('biznisi');
        Route::get('/biznisi/novi', [BusinessesController::class, 'create'])->name('biznisi.create');
        Route::post('/biznisi', [BusinessesController::class, 'store'])->name('biznisi.store');
        Route::get('/biznisi/{business}/uredi', [BusinessesController::class, 'edit'])->name('biznisi.edit');
        Route::put('/biznisi/{business}', [BusinessesController::class, 'update'])->name('biznisi.update');
        Route::delete('/biznisi/{business}', [BusinessesController::class, 'destroy'])->name('biznisi.destroy');
        Route::post('/biznisi/{business}/odobri', [BusinessesController::class, 'approve'])->name('biznisi.approve');
        Route::post('/biznisi/{business}/vrati', [BusinessesController::class, 'vrati'])->name('biznisi.vrati');
        Route::post('/biznisi/{business}/odbij', [BusinessesController::class, 'reject'])->name('biznisi.reject');
        Route::post('/biznisi/{business}/odobri-izmjene', [BusinessesController::class, 'approveChanges'])->name('biznisi.approveChanges');
        Route::post('/biznisi/{business}/vrati-izmjene', [BusinessesController::class, 'returnChanges'])->name('biznisi.returnChanges');
        Route::post('/biznisi/{business}/odbij-izmjene', [BusinessesController::class, 'rejectChanges'])->name('biznisi.rejectChanges');
        Route::post('/biznisi/{business}/logo', [BusinessesController::class, 'uploadLogo'])->name('biznisi.logo');
        Route::delete('/biznisi/{business}/logo', [BusinessesController::class, 'destroyLogo'])->name('biznisi.logo.destroy');
        Route::post('/biznisi/{business}/naslovna', [BusinessesController::class, 'uploadNaslovna'])->name('biznisi.naslovna');
        Route::delete('/biznisi/{business}/naslovna', [BusinessesController::class, 'destroyNaslovna'])->name('biznisi.naslovna.destroy');
        Route::post('/biznisi/{business}/galerija', [BusinessesController::class, 'uploadGalerija'])->name('biznisi.galerija');
        Route::post('/biznisi/galerija/{media}/zamijeni', [BusinessesController::class, 'replaceGalerija'])->name('biznisi.galerija.zamijeni');
        Route::post('/biznisi/{business}/galerija/redoslijed', [BusinessesController::class, 'reorderGalerija'])->name('biznisi.galerija.redoslijed');
        Route::delete('/biznisi/galerija/{media}', [BusinessesController::class, 'destroyGalerija'])->name('biznisi.galerija.destroy');

        foreach ([
            'turizam' => LocationsController::class,
            'dogadjaji' => EventsController::class,
            'oglasi' => AdsController::class,
            'price' => StoriesController::class,
            'vijesti' => NewsController::class,
            'nabavke' => ProcurementsController::class,
        ] as $baza => $ctrl) {
            Route::get("/{$baza}", [$ctrl, 'index'])->name($baza);
            Route::get("/{$baza}/novi", [$ctrl, 'create'])->name("{$baza}.create");
            Route::post("/{$baza}", [$ctrl, 'store'])->name("{$baza}.store");
            Route::post("/{$baza}/galerija/{media}/zamijeni", [$ctrl, 'replaceGalerija'])->name("{$baza}.galerija.zamijeni");
            Route::delete("/{$baza}/galerija/{media}", [$ctrl, 'destroyGalerija'])->name("{$baza}.galerija.destroy");
            Route::get("/{$baza}/{id}/uredi", [$ctrl, 'edit'])->whereNumber('id')->name("{$baza}.edit");
            Route::put("/{$baza}/{id}", [$ctrl, 'update'])->whereNumber('id')->name("{$baza}.update");
            Route::delete("/{$baza}/{id}", [$ctrl, 'destroy'])->whereNumber('id')->name("{$baza}.destroy");
            Route::post("/{$baza}/{id}/odobri", [$ctrl, 'approve'])->whereNumber('id')->name("{$baza}.approve");
            Route::post("/{$baza}/{id}/vrati", [$ctrl, 'vrati'])->whereNumber('id')->name("{$baza}.vrati");
            Route::post("/{$baza}/{id}/odbij", [$ctrl, 'reject'])->whereNumber('id')->name("{$baza}.reject");
            Route::post("/{$baza}/{id}/odobri-izmjene", [$ctrl, 'approveChanges'])->whereNumber('id')->name("{$baza}.approveChanges");
            Route::post("/{$baza}/{id}/vrati-izmjene", [$ctrl, 'returnChanges'])->whereNumber('id')->name("{$baza}.returnChanges");
            Route::post("/{$baza}/{id}/odbij-izmjene", [$ctrl, 'rejectChanges'])->whereNumber('id')->name("{$baza}.rejectChanges");
            Route::post("/{$baza}/{id}/naslovna", [$ctrl, 'uploadNaslovna'])->whereNumber('id')->name("{$baza}.naslovna");
            Route::delete("/{$baza}/{id}/naslovna", [$ctrl, 'destroyNaslovna'])->whereNumber('id')->name("{$baza}.naslovna.destroy");
            Route::post("/{$baza}/{id}/galerija", [$ctrl, 'uploadGalerija'])->whereNumber('id')->name("{$baza}.galerija");
            Route::post("/{$baza}/{id}/galerija/redoslijed", [$ctrl, 'reorderGalerija'])->whereNumber('id')->name("{$baza}.galerija.redoslijed");
        }

        Route::post('/nabavke/{id}/dokument', [ProcurementsController::class, 'uploadDokument'])->whereNumber('id')->name('nabavke.dokument');
        Route::delete('/nabavke/dokument/{media}', [ProcurementsController::class, 'destroyDokument'])->name('nabavke.dokument.destroy');

        Route::get('/kategorije', [CategoriesController::class, 'index'])->name('kategorije');
        Route::get('/kategorije/nova', [CategoriesController::class, 'create'])->name('kategorije.create');
        Route::post('/kategorije', [CategoriesController::class, 'store'])->name('kategorije.store');
        Route::post('/kategorije/redoslijed', [CategoriesController::class, 'reorder'])->name('kategorije.redoslijed');
        Route::get('/kategorije/{category}/uredi', [CategoriesController::class, 'edit'])->name('kategorije.edit');
        Route::put('/kategorije/{category}', [CategoriesController::class, 'update'])->name('kategorije.update');
        Route::delete('/kategorije/{category}', [CategoriesController::class, 'destroy'])->name('kategorije.destroy');

        Route::get('/navigacija', [NavigacijaController::class, 'index'])->name('navigacija');
        Route::post('/navigacija/{menu}/stavke', [NavigacijaController::class, 'store'])->name('navigacija.store');
        Route::post('/navigacija/{menu}/redoslijed', [NavigacijaController::class, 'reorder'])->name('navigacija.redoslijed');
        Route::put('/navigacija/stavke/{stavka}', [NavigacijaController::class, 'update'])->name('navigacija.update');
        Route::post('/navigacija/stavke/{stavka}/vidljivost', [NavigacijaController::class, 'toggle'])->name('navigacija.toggle');
        Route::delete('/navigacija/stavke/{stavka}', [NavigacijaController::class, 'destroy'])->name('navigacija.destroy');
    });

    Route::middleware('admin.access:sistemske postavke')->group(function () {
        Route::get('/prevodi', [TranslationsController::class, 'index'])->name('translations');
        Route::put('/prevodi/{translation}', [TranslationsController::class, 'update'])->name('translations.update');

        Route::get('/postavke', [SettingsController::class, 'index'])->name('settings');
        Route::put('/postavke', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('/postavke/logo', [SettingsController::class, 'logo'])->name('settings.logo');
        Route::delete('/postavke/logo', [SettingsController::class, 'obrisiLogo'])->name('settings.logo.obrisi');
        Route::post('/postavke/og-slika', [SettingsController::class, 'ogImage'])->name('settings.og.slika');
        Route::delete('/postavke/og-slika', [SettingsController::class, 'obrisiOgImage'])->name('settings.og.slika.obrisi');

        Route::post('/postavke/partneri', [PartnersController::class, 'store'])->name('settings.partneri.store');
        Route::post('/postavke/partneri/redoslijed', [PartnersController::class, 'redoslijed'])->name('settings.partneri.redoslijed');
        Route::put('/postavke/partneri/{partner}', [PartnersController::class, 'update'])->name('settings.partneri.update');
        Route::delete('/postavke/partneri/{partner}', [PartnersController::class, 'destroy'])->name('settings.partneri.destroy');
        Route::post('/postavke/partneri/{partner}/logo', [PartnersController::class, 'logo'])->name('settings.partneri.logo');
        Route::delete('/postavke/partneri/{partner}/logo', [PartnersController::class, 'obrisiLogo'])->name('settings.partneri.logo.obrisi');

        Route::get('/jezici', [LanguagesController::class, 'index'])->name('languages');
        Route::post('/jezici', [LanguagesController::class, 'store'])->name('languages.store');
        Route::put('/jezici/{locale}', [LanguagesController::class, 'update'])->name('languages.update');
        Route::delete('/jezici/{locale}', [LanguagesController::class, 'destroy'])->name('languages.destroy');
    });

    Route::get('/logovi', [LogoviController::class, 'index'])
        ->middleware('admin.access:pregled logova')
        ->name('logovi');

    Route::get('/logovi/izvoz', [LogoviController::class, 'izvoz'])
        ->middleware('admin.access:pregled logova')
        ->name('logovi.izvoz');

    Route::post('/odjava', [AuthController::class, 'odjava'])->name('odjava');
});
