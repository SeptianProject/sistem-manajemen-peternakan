@php
    $user = auth()->user();
    $isSuperadmin = $user->role === 'admin';
@endphp

<aside class="dashboard-sidebar">
    <a href="{{ route('dashboard') }}" class="dashboard-brand">
        <span class="dashboard-brand-icon"><i class="bi bi-grid-3x3-gap-fill"></i></span>
        Livestock<span>ID</span>
    </a>

    <div class="dashboard-role">
        <span class="dashboard-role-label">Login sebagai</span>
        <strong>{{ $isSuperadmin ? 'Superadmin' : ucfirst($user->role) }}</strong>
    </div>

    <nav class="dashboard-nav" aria-label="Navigasi dashboard">
        <a href="{{ route('dashboard') }}" class="dashboard-nav-link active">
            <i class="bi bi-speedometer2"></i> Overview
        </a>

        @if ($isSuperadmin)
            <a href="{{ route('management.clients.index') }}" class="dashboard-nav-link">
                <i class="bi bi-buildings"></i> Data Peternakan
            </a>
            <a href="{{ route('management.users.index') }}" class="dashboard-nav-link">
                <i class="bi bi-people"></i> Manajemen Pengguna
            </a>
            <a href="{{ route('management.reports') }}" class="dashboard-nav-link">
                <i class="bi bi-bar-chart-line"></i> Laporan Sistem
            </a>
        @elseif ($user->role === 'pemilik')
            <a href="{{ route('management.ternak.index') }}" class="dashboard-nav-link">
                <i class="bi bi-box-seam"></i> Data Ternak
            </a>
            <a href="{{ route('management.kandang.index') }}" class="dashboard-nav-link">
                <i class="bi bi-house-door"></i> Kandang
            </a>
            <a href="{{ route('management.health-records.index') }}" class="dashboard-nav-link">
                <i class="bi bi-heart-pulse"></i> Kesehatan Ternak
            </a>
            <a href="{{ route('management.production-records.index') }}" class="dashboard-nav-link">
                <i class="bi bi-droplet-half"></i> Produksi
            </a>
        @else
            <a href="{{ route('management.ternak.index') }}" class="dashboard-nav-link">
                <i class="bi bi-pencil-square"></i> Input Data
            </a>
            <a href="{{ route('management.health-records.index') }}" class="dashboard-nav-link">
                <i class="bi bi-heart-pulse"></i> Rekam Kesehatan
            </a>
            <a href="{{ route('management.production-records.index') }}" class="dashboard-nav-link">
                <i class="bi bi-droplet-half"></i> Catatan Produksi
            </a>
        @endif
    </nav>

    <form action="{{ route('logout') }}" method="post" class="dashboard-logout">
        @csrf
        <button type="submit" class="dashboard-nav-link dashboard-logout-button">
            <i class="bi bi-box-arrow-left"></i> Keluar
        </button>
    </form>
</aside>
