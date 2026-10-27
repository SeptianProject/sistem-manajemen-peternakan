<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') — LivestockID</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    {{-- Ganti dengan file CSS dashboard Anda (bukan style.css milik landing) --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard-app.css') }}" />
</head>

<body>
    <div class="layout">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon"><i class="bi bi-grid-fill"></i></div>
                <div class="brand-name">Livestock<span>ID</span></div>
            </div>
            <nav class="sidebar-nav">
                <p class="nav-section-label">Menu Utama</p>
                <ul style="list-style:none;padding:0;margin:0;">
                    <li class="nav-item"><a href="{{ url('/dashboard') }}" class="nav-link-item"><i class="bi bi-speedometer2"></i><span>Overview</span></a></li>
                    <li class="nav-item"><a href="{{ url('/ternak') }}" class="nav-link-item"><i class="bi bi-box-seam"></i><span>Ternak</span></a></li>
                    <li class="nav-item"><a href="{{ url('/kandang') }}" class="nav-link-item"><i class="bi bi-house-door"></i><span>Kandang</span></a></li>
                    <li class="nav-item"><a href="{{ url('/petugas') }}" class="nav-link-item"><i class="bi bi-people"></i><span>Petugas</span></a></li>
                </ul>
                <p class="nav-section-label">Pencatatan</p>
                <ul style="list-style:none;padding:0;margin:0;">
                    <li class="nav-item"><a href="{{ url('/rekam-kesehatan') }}" class="nav-link-item"><i class="bi bi-heart-pulse"></i><span>Rekam Kesehatan</span></a></li>
                    <li class="nav-item"><a href="{{ url('/catatan-produksi') }}" class="nav-link-item {{ request()->is('catatan-produksi*') ? 'active' : '' }}"><i class="bi bi-journal-richtext"></i><span>Catatan Produksi</span></a></li>
                    <li class="nav-item" style="margin-left: 20px;"><a href="{{ url('/jenis-produksi') }}" class="nav-link-item {{ request()->is('jenis-produksi*') ? 'active' : '' }}"><i class="bi bi-droplet-half"></i><span>Jenis Produksi</span></a></li>
                </ul>
            </nav>
            <div class="sidebar-footer"><a href="{{ url('/login') }}" class="nav-link-item"><i class="bi bi-box-arrow-left"></i><span>Keluar</span></a></div>
        </aside>
        <div class="main-area">
            <header class="topbar">
                <button class="sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="bi bi-list"></i></button>
                <span class="topbar-title">@yield('topbar-title')</span>
            </header>
            <main class="page-content">
                @include('partials.alerts')
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>