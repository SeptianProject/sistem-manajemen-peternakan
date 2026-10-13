<?php

use Illuminate\Support\Facades\Route;
use Modules\Produksi\Http\Controllers\ProduksiController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('produksis', ProduksiController::class)->names('produksi');
});
