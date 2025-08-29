<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/juego', function () {
    return view('juego');
})->name('juego');

Route::get('/ranking', function () {
    return view('ranking');
})->name('ranking');
