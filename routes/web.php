<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.inicio');
})->name('home');

Route::get('/juego', function () {
    return view('pages.juego');
})->name('juego');

Route::get('/ranking', function () {
    return view('pages.ranking');
})->name('ranking');
