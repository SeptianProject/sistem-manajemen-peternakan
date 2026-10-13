<?php 

namespace App\Modules;

use Illuminate\Support\ServiceProvider;


abstract class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $path = $this->modulePath();
    }
}