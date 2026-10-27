<?php

use App\Modules\Auth\AuthServiceProvider;
use App\Modules\Dashboard\DashboardServiceProvider;
use App\Modules\Management\ManagementServiceProvider;
use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    DashboardServiceProvider::class,
    ManagementServiceProvider::class,
];
