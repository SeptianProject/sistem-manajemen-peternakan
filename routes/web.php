<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'landing');
Route::view('/landing', 'landing');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

// Sementara: form submit langsung ke halaman Ternak
Route::post('/login', fn () => redirect('/ternak'))->name('login.attempt');
Route::post('/register', fn () => redirect('/ternak'))->name('register.store');
Route::post('/logout', fn () => redirect('/login'))->name('logout');

Route::view('/client/dashboard/catatan-produksi', 'catatan-produksi.index');
Route::view('/client/dashboard/catatan-produksi/create', 'catatan-produksi.create');
Route::view('/client/dashboard/catatan-produksi/{id}/edit', 'catatan-produksi.edit');

Route::view('/client/dashboard/jenis-produksi', 'jenis-produksi.index');
Route::view('/client/dashboard/jenis-produksi/create', 'jenis-produksi.create');
Route::view('/client/dashboard/jenis-produksi/{id}/edit', 'jenis-produksi.edit');

// require __DIR__ . '/pages.php';
// Route::view('/', 'landing');