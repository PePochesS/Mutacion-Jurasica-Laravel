<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\AuthController;

// Home
Route::get('/', [GameController::class, 'index'])->name('home');

// Juego
Route::post('/juego/start', [GameController::class, 'start'])
    ->middleware('auth')
    ->name('juego.start');

Route::get('/juego', [GameController::class, 'play'])
    ->middleware('auth')
    ->name('juego');

Route::post('/juego/score', [GameController::class, 'submitScore'])
    ->middleware('auth')
    ->name('juego.score');

// FINALIZAR PARTIDA -> ahora va a ScoreController@end
Route::post('/juego/end', [ScoreController::class, 'end'])
    ->middleware('auth')
    ->name('juego.end');

// Ranking
Route::get('/ranking', [ScoreController::class, 'index'])->name('ranking');

// Auth (modals)
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
