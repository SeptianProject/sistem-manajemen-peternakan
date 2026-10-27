<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return match (auth()->user()->role) {
            'admin' => view('modules.dashboard.admin.index'),
            'pemilik' => view('modules.dashboard.pemilik.index'),
            'petugas' => view('modules.dashboard.petugas.index'),
        };
    }
}
