@extends('modules.dashboard.layouts.app')

@section('title', 'Dashboard Petugas')
@section('eyebrow', 'Petugas')
@section('heading', 'Selamat datang, '.auth()->user()->nama.'!')
@section('description', 'Catat dan pantau aktivitas operasional peternakan.')

@section('content')
    <section class="dashboard-stat-grid" aria-label="Ringkasan aktivitas petugas">
        @include('modules.dashboard.components.stat-card', [
            'icon' => 'bi-pencil-square',
            'label' => 'Input Hari Ini',
            'description' => 'Data yang dicatat hari ini',
        ])
        @include('modules.dashboard.components.stat-card', [
            'icon' => 'bi-heart-pulse',
            'color' => 'blue',
            'label' => 'Pemeriksaan',
            'description' => 'Rekam kesehatan ternak',
        ])
        @include('modules.dashboard.components.stat-card', [
            'icon' => 'bi-droplet-half',
            'color' => 'orange',
            'label' => 'Produksi',
            'description' => 'Catatan produksi hari ini',
        ])
    </section>

    <section class="dashboard-content-grid">
        @include('modules.dashboard.components.profile-card')
        @include('modules.dashboard.components.empty-state')
    </section>
@endsection
