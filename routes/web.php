<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\AuthController;

// Home
Route::get('/', [GameController::class, 'index'])->name('home');

// Juego
Route::get('/juego', [GameController::class, 'play'])->name('juego');
Route::post('/juego/score', [GameController::class, 'submitScore'])->name('juego.score');
Route::post('/juego/end', [GameController::class, 'endGame'])->name('juego.end');

// Ranking
Route::get('/ranking', [ScoreController::class, 'index'])->name('ranking');

// Auth (modals)
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
