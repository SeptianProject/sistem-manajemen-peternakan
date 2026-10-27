@php
    $user = auth()->user();
    $roleLabel = $user->role === 'admin' ? 'Superadmin' : 'Pemilik Peternakan';
@endphp

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
        @if ($user->role !== 'admin')
            <div>
                <dt>Peternakan</dt>
                <dd>{{ $user->client?->nama_peternakan ?? 'Belum terhubung' }}</dd>
            </div>
        @endif
    </dl>
</article>
