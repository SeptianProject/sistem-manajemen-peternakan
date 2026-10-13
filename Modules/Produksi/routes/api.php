<?php

use Illuminate\Support\Facades\Route;
use Modules\Produksi\Http\Controllers\ProduksiController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('produksis', ProduksiController::class)->names('produksi');
});
