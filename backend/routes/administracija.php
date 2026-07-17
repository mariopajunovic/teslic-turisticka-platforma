<?php

use App\Http\Controllers\Administracija\AdministratoriController;
use App\Http\Controllers\Administracija\AuthController;
use App\Http\Controllers\Administracija\DashboardController;
use App\Http\Controllers\Administracija\KorisniciController;
use App\Http\Controllers\Administracija\LogoviController;
use App\Http\Controllers\Administracija\LozinkaController;
use App\Http\Controllers\Administracija\LanguagesController;
use App\Http\Controllers\Administracija\Obavezni2faController;
use App\Http\Controllers\Administracija\ProfilController;
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

    Route::middleware('admin.access:sistemske postavke')->group(function () {
        Route::get('/prevodi', [TranslationsController::class, 'index'])->name('translations');
        Route::put('/prevodi/{translation}', [TranslationsController::class, 'update'])->name('translations.update');

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
