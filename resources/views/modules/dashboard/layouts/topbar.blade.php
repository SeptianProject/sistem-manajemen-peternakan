@php
    $user = auth()->user();
    $roleLabel = match ($user->role) {
        'admin' => 'Superadmin',
        'pemilik' => 'Pemilik Peternakan',
        default => 'Petugas Lapangan',
    };
@endphp

<header class="dashboard-header">
    <p class="dashboard-header-title">Overview</p>

    <div class="dashboard-header-actions">
        <span class="dashboard-notification" aria-hidden="true">
            <i class="bi bi-bell"></i>
            <span></span>
        </span>
        <div class="dashboard-user">
            <div class="dashboard-user-copy">
                <strong>{{ $user->nama }}</strong>
                <span>{{ $roleLabel }}</span>
            </div>
            <div class="dashboard-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->nama, 0, 1)) }}</div>
        </div>
    </div>
</header>
