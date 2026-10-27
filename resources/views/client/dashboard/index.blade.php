@php
    $user = auth()->user();
    $isSuperadmin = $user->role === 'admin';
    $roleLabel = $isSuperadmin ? 'Superadmin' : 'Pemilik Peternakan';
@endphp

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LivestockID</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/client-dashboard.css') }}">
</head>

<body class="client-dashboard">
    <aside class="dashboard-sidebar">
        <a href="{{ route('dashboard') }}" class="dashboard-brand">
            <span class="dashboard-brand-icon"><i class="bi bi-grid-3x3-gap-fill"></i></span>
            Livestock<span>ID</span>
        </a>

        <div class="dashboard-role">
            <span class="dashboard-role-label">Login sebagai</span>
            <strong>{{ $roleLabel }}</strong>
        </div>

        <nav class="dashboard-nav" aria-label="Navigasi dashboard">
            <a href="{{ route('dashboard') }}" class="dashboard-nav-link active">
                <i class="bi bi-speedometer2"></i> Overview
            </a>

            @if ($isSuperadmin)
                <a href="#" class="dashboard-nav-link">
                    <i class="bi bi-buildings"></i> Data Peternakan
                </a>
                <a href="#" class="dashboard-nav-link">
                    <i class="bi bi-people"></i> Manajemen Pengguna
                </a>
                <a href="#" class="dashboard-nav-link">
                    <i class="bi bi-bar-chart-line"></i> Laporan Sistem
                </a>
            @else
                <a href="#" class="dashboard-nav-link">
                    <i class="bi bi-box-seam"></i> Data Ternak
                </a>
                <a href="#" class="dashboard-nav-link">
                    <i class="bi bi-house-door"></i> Kandang
                </a>
                <a href="#" class="dashboard-nav-link">
                    <i class="bi bi-heart-pulse"></i> Kesehatan Ternak
                </a>
                <a href="#" class="dashboard-nav-link">
                    <i class="bi bi-droplet-half"></i> Produksi
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

    <main class="dashboard-main">
        <header class="dashboard-header">
            <div>
                <p class="dashboard-eyebrow">Dashboard</p>
                <h1>Selamat datang, {{ $user->nama }}!</h1>
                <p class="dashboard-muted mb-0">
                    Berikut ringkasan informasi terbaru untuk akun Anda.
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

        <section class="dashboard-stat-grid" aria-label="Ringkasan statistik">
            @if ($isSuperadmin)
                <article class="dashboard-stat-card">
                    <span class="dashboard-stat-icon green"><i class="bi bi-buildings"></i></span>
                    <span class="dashboard-stat-label">Total Peternakan</span>
                    <strong>0</strong>
                    <small>Belum ada data tambahan</small>
                </article>
                <article class="dashboard-stat-card">
                    <span class="dashboard-stat-icon blue"><i class="bi bi-people"></i></span>
                    <span class="dashboard-stat-label">Total Pengguna</span>
                    <strong>0</strong>
                    <small>Pengguna terdaftar</small>
                </article>
                <article class="dashboard-stat-card">
                    <span class="dashboard-stat-icon orange"><i class="bi bi-activity"></i></span>
                    <span class="dashboard-stat-label">Aktivitas Hari Ini</span>
                    <strong>0</strong>
                    <small>Aktivitas tercatat</small>
                </article>
            @else
                <article class="dashboard-stat-card">
                    <span class="dashboard-stat-icon green"><i class="bi bi-box-seam"></i></span>
                    <span class="dashboard-stat-label">Total Ternak</span>
                    <strong>0</strong>
                    <small>Data ternak aktif</small>
                </article>
                <article class="dashboard-stat-card">
                    <span class="dashboard-stat-icon blue"><i class="bi bi-house-door"></i></span>
                    <span class="dashboard-stat-label">Total Kandang</span>
                    <strong>0</strong>
                    <small>Kandang terdaftar</small>
                </article>
                <article class="dashboard-stat-card">
                    <span class="dashboard-stat-icon orange"><i class="bi bi-droplet-half"></i></span>
                    <span class="dashboard-stat-label">Produksi Hari Ini</span>
                    <strong>0</strong>
                    <small>Belum ada pencatatan</small>
                </article>
            @endif
        </section>

        <section class="dashboard-content-grid">
            <article class="dashboard-panel">
                <div class="dashboard-panel-heading">
                    <div>
                        <p class="dashboard-eyebrow">Informasi akun</p>
                        <h2>Profil {{ $roleLabel }}</h2>
                    </div>
                    <i class="bi bi-person-circle dashboard-panel-icon"></i>
                </div>

                <dl class="dashboard-profile-list">
                    <div>
                        <dt>Nama</dt>
                        <dd>{{ $user->nama }}</dd>
                    </div>
                    <div>
                        <dt>Username</dt>
                        <dd>{{ $user->username }}</dd>
                    </div>
                    <div>
                        <dt>Status akun</dt>
                        <dd><span class="dashboard-status">Aktif</span></dd>
                    </div>
                    @if (! $isSuperadmin)
                        <div>
                            <dt>Peternakan</dt>
                            <dd>{{ $user->client?->nama_peternakan ?? 'Belum terhubung' }}</dd>
                        </div>
                    @endif
                </dl>
            </article>

            <article class="dashboard-panel dashboard-empty-panel">
                <span class="dashboard-empty-icon"><i class="bi bi-bar-chart-line"></i></span>
                <h2>Data dashboard belum tersedia</h2>
                <p class="dashboard-muted">
                    Modul operasional akan menampilkan data di area ini setelah data peternakan mulai dicatat.
                </p>
            </article>
        </section>
    </main>
</body>

</html>
