<?php

namespace App\Modules\Dashboard;

use App\Modules\Dashboard\Http\Controllers\DashboardController;
use App\Modules\ModuleServiceProvider;
use Illuminate\Support\Facades\Route;

class DashboardServiceProvider extends ModuleServiceProvider
{
    public function boot(): void
    {
        Route::middleware(['web', 'auth'])
            ->group(function (): void {
                Route::get('/dashboard', DashboardController::class)->name('dashboard');
            });
    }
}
