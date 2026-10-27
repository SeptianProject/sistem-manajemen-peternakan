<?php

namespace App\Modules\Management;

use App\Modules\Management\Http\Controllers\ResourceController;
use App\Modules\ModuleServiceProvider;
use Illuminate\Support\Facades\Route;

class ManagementServiceProvider extends ModuleServiceProvider
{
    public function boot(): void
    {
        Route::middleware(['web', 'auth'])->prefix('management')->name('management.')->group(function (): void {
            foreach (array_keys(ResourceController::CONFIG) as $resource) {
                Route::get($resource, [ResourceController::class, 'index'])->name($resource.'.index')->defaults('resource', $resource);
                Route::get($resource.'/create', [ResourceController::class, 'create'])->name($resource.'.create')->defaults('resource', $resource);
                Route::post($resource, [ResourceController::class, 'store'])->name($resource.'.store')->defaults('resource', $resource);
                Route::get($resource.'/{id}/edit', [ResourceController::class, 'edit'])->name($resource.'.edit')->defaults('resource', $resource);
                Route::put($resource.'/{id}', [ResourceController::class, 'update'])->name($resource.'.update')->defaults('resource', $resource);
                Route::delete($resource.'/{id}', [ResourceController::class, 'destroy'])->name($resource.'.destroy')->defaults('resource', $resource);
            }
            Route::get('reports', [ResourceController::class, 'reports'])->name('reports');
        });

        $register = static function (string $prefix, array $resources): void {
            Route::middleware(['web', 'auth'])->prefix($prefix)->name($prefix.'.')->group(function () use ($resources): void {
                foreach ($resources as $resource) {
                    Route::get($resource, [ResourceController::class, 'index'])->name($resource.'.index')->defaults('resource', $resource);
                    Route::get($resource.'/create', [ResourceController::class, 'create'])->name($resource.'.create')->defaults('resource', $resource);
                    Route::post($resource, [ResourceController::class, 'store'])->name($resource.'.store')->defaults('resource', $resource);
                    Route::get($resource.'/{id}/edit', [ResourceController::class, 'edit'])->name($resource.'.edit')->defaults('resource', $resource);
                    Route::put($resource.'/{id}', [ResourceController::class, 'update'])->name($resource.'.update')->defaults('resource', $resource);
                    Route::delete($resource.'/{id}', [ResourceController::class, 'destroy'])->name($resource.'.destroy')->defaults('resource', $resource);
                }
            });
        };
        $register('admin', ['clients', 'users', 'jenis-ternak', 'jenis-produksi', 'tindakan', 'jabatan']);
        $register('owner', ['ternak', 'kandang', 'health-records', 'production-records', 'petugas']);
        $register('staff', ['ternak', 'health-records', 'production-records']);
    }
}
