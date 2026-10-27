@extends('modules.dashboard.layouts.app')

@section('title', 'Dashboard Pemilik')
@section('eyebrow', 'Pemilik Peternakan')
@section('heading', 'Selamat datang, '.auth()->user()->nama.'!')
@section('description', 'Pantau kondisi dan aktivitas peternakan Anda.')

@section('content')
    <section class="dashboard-stat-grid" aria-label="Ringkasan statistik peternakan">
        @include('modules.dashboard.components.stat-card', [
            'icon' => 'bi-box-seam',
            'label' => 'Total Ternak',
            'description' => 'Data ternak aktif',
        ])
        @include('modules.dashboard.components.stat-card', [
            'icon' => 'bi-house-door',
            'color' => 'blue',
            'label' => 'Total Kandang',
            'description' => 'Kandang terdaftar',
        ])
        @include('modules.dashboard.components.stat-card', [
            'icon' => 'bi-droplet-half',
            'color' => 'orange',
            'label' => 'Produksi Hari Ini',
            'description' => 'Belum ada pencatatan',
        ])
    </section>

    <section class="dashboard-content-grid">
        @include('modules.dashboard.components.profile-card')
        @include('modules.dashboard.components.empty-state')
    </section>
@endsection
