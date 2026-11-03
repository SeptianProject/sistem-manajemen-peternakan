@php
    $user = auth()->user();
    $navigationGroups = match ($user->role) {
        'admin' => [
            [
                'label' => 'MENU UTAMA',
                'items' => [
                    ['label' => 'Overview', 'icon' => 'bi-speedometer2', 'route' => 'dashboard'],
                    ['label' => 'Data Peternakan', 'icon' => 'bi-buildings', 'route' => 'management.clients.index'],
                    ['label' => 'Manajemen Pengguna', 'icon' => 'bi-people', 'route' => 'management.users.index'],
                ],
            ],
            [
                'label' => 'PENCATATAN',
                'items' => [
                    ['label' => 'Laporan Sistem', 'icon' => 'bi-bar-chart-line', 'route' => 'management.reports'],
                ],
            ],
        ],
        'pemilik' => [
            [
                'label' => 'MENU UTAMA',
                'items' => [
                    ['label' => 'Overview', 'icon' => 'bi-speedometer2', 'route' => 'dashboard'],
                    ['label' => 'Ternak', 'icon' => 'bi-box-seam', 'route' => 'owner.ternak.index'],
                    ['label' => 'Kandang', 'icon' => 'bi-house-door', 'route' => 'owner.kandang.index'],
                    ['label' => 'Petugas', 'icon' => 'bi-people', 'route' => 'owner.petugas.index'],
                ],
            ],
            [
                'label' => 'PENCATATAN',
                'items' => [
                    ['label' => 'Rekam Kesehatan', 'icon' => 'bi-heart-pulse', 'route' => 'owner.health-records.index'],
                    ['label' => 'Catatan Produksi', 'icon' => 'bi-droplet-half', 'route' => 'owner.production-records.index'],
                ],
            ],
        ],
        default => [
            [
                'label' => 'MENU UTAMA',
                'items' => [
                    ['label' => 'Overview', 'icon' => 'bi-speedometer2', 'route' => 'dashboard'],
                    ['label' => 'Input Data Ternak', 'icon' => 'bi-box-seam', 'route' => 'staff.ternak.index'],
                ],
            ],
            [
                'label' => 'PENCATATAN',
                'items' => [
                    ['label' => 'Rekam Kesehatan', 'icon' => 'bi-heart-pulse', 'route' => 'staff.health-records.index'],
                    ['label' => 'Catatan Produksi', 'icon' => 'bi-droplet-half', 'route' => 'staff.production-records.index'],
                ],
            ],
        ],
    };
@endphp

<aside class="dashboard-sidebar">
    <a href="{{ route('dashboard') }}" class="dashboard-brand" aria-label="LivestockID beranda">
        <span class="dashboard-brand-icon"><i class="bi bi-grid-3x3-gap-fill"></i></span>
        <span>Livestock<span class="dashboard-brand-accent">ID</span></span>
    </a>

    <nav class="dashboard-navigation" aria-label="Navigasi dashboard">
        @foreach ($navigationGroups as $group)
            <div class="dashboard-nav-group">
                <p class="dashboard-nav-label">{{ $group['label'] }}</p>
                <div class="dashboard-nav-items">
                    @foreach ($group['items'] as $item)
                        @php($isActive = request()->routeIs($item['route']))
                        <a
                            href="{{ route($item['route']) }}"
                            class="dashboard-nav-link{{ $isActive ? ' active' : '' }}"
                            @if ($isActive) aria-current="page" @endif
                        >
                            <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <form action="{{ route('logout') }}" method="post" class="dashboard-logout">
        @csrf
        <button type="submit" class="dashboard-nav-link dashboard-logout-button">
            <i class="bi bi-box-arrow-left" aria-hidden="true"></i>
            <span>Keluar</span>
        </button>
    </form>
</aside>
