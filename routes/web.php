<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::view('/', 'landing');
Route::view('/landing', 'landing');
Route::view('/dashboard', 'client.dashboard.index')
    ->middleware('auth')
    ->name('dashboard');
