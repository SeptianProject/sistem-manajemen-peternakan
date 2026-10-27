@php
    $user = auth()->user();
    $roleLabel = $user->role === 'admin' ? 'Superadmin' : ucfirst($user->role);
@endphp

<header class="dashboard-header">
    <div>
        <p class="dashboard-eyebrow">@yield('eyebrow', 'Dashboard')</p>
        <h1>@yield('heading', 'Selamat datang, '.$user->nama.'!')</h1>
        <p class="dashboard-muted mb-0">
            @yield('description', 'Berikut ringkasan informasi terbaru untuk akun Anda.')
        </p>
    </div>

    <div class="dashboard-user">
        <div class="dashboard-avatar">{{ mb_strtoupper(mb_substr($user->nama, 0, 1)) }}</div>
        <div>
            <strong>{{ $user->nama }}</strong>
            <span>{{ $roleLabel }}</span>
        </div>
    </div>
</header>
