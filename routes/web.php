<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;

/* Español */

// Home
Route::get('/', [GameController::class, 'index'])->name('home');

// Juego
Route::post('/juego/start', [GameController::class, 'start'])
    ->middleware('auth')->name('juego.start');

Route::get('/juego', [GameController::class, 'play'])
    ->middleware('auth')->name('juego');

Route::post('/juego/score', [GameController::class, 'submitScore'])
    ->middleware('auth')->name('juego.score');

Route::post('/juego/end', [ScoreController::class, 'end'])
    ->middleware('auth')->name('juego.end');

// Ranking
Route::get('/ranking', [ScoreController::class, 'index'])->name('ranking');

// Auth
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// Opciones
Route::get('/opciones', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/idioma',  [SettingsController::class, 'switchLocale'])->name('settings.locale');

// Extras
Route::view('/extras', 'pages.extras')->name('extras.index');


/* English */

Route::prefix('en')->name('en.')->group(function () {

    // Home EN
    Route::view('/', 'pages.inicioEN')->name('home');

    // Extras EN
    Route::view('/extras', 'pages.extrasEN')->name('extras');

    // Options EN
    Route::view('/options', 'pages.opcionesEN')->name('options');

    // Ranking EN 
    Route::get('/ranking', [ScoreController::class, 'index'])->name('ranking');

    // Game EN 
    Route::get('/game', [GameController::class, 'play'])
        ->middleware('auth')->name('game');

    Route::post('/game/start', [GameController::class, 'start'])
        ->middleware('auth')->name('game.start');
});
