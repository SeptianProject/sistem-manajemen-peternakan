<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

// Sementara: form submit langsung ke halaman Ternak
Route::post('/login', fn () => redirect('/ternak'))->name('login.attempt');
Route::post('/register', fn () => redirect('/ternak'))->name('register.store');
Route::post('/logout', fn () => redirect('/login'))->name('logout');
