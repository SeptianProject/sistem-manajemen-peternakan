@extends('modules.dashboard.layouts.app')

@section('title', 'Dashboard Superadmin')
@section('eyebrow', 'Superadmin')
@section('heading', 'Selamat datang, '.auth()->user()->nama.'!')
@section('description', 'Kelola seluruh peternakan dan pengguna dari satu tempat.')

@section('content')
    <section class="dashboard-stat-grid" aria-label="Ringkasan statistik superadmin">
        @include('modules.dashboard.components.stat-card', [
            'icon' => 'bi-buildings',
            'label' => 'Total Peternakan',
            'description' => 'Belum ada data tambahan',
        ])
        @include('modules.dashboard.components.stat-card', [
            'icon' => 'bi-people',
            'color' => 'blue',
            'label' => 'Total Pengguna',
            'description' => 'Pengguna terdaftar',
        ])
        @include('modules.dashboard.components.stat-card', [
            'icon' => 'bi-activity',
            'color' => 'orange',
            'label' => 'Aktivitas Hari Ini',
            'description' => 'Aktivitas tercatat',
        ])
    </section>

    <section class="dashboard-content-grid">
        @include('modules.dashboard.components.profile-card')
        @include('modules.dashboard.components.empty-state')
    </section>
@endsection
