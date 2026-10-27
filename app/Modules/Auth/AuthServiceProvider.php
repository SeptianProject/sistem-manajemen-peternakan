<?php

namespace App\Modules\Auth;

use App\Modules\ModuleServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AuthServiceProvider extends ModuleServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request): Limit {
            return Limit::perMinute(5)->by(
                strtolower((string) $request->input('username')).'|'.$request->ip()
            );
        });

        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}
