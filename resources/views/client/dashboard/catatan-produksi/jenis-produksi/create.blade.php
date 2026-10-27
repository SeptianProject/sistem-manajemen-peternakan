<div>
@extends('layouts.app')

@section('title', 'Tambah Jenis Produksi')
@section('topbar-title', 'Tambah Jenis Produksi')

@section('content')
    <div class="page-header">
        <h1>Tambah Jenis Produksi Baru</h1>
        <p>Master data untuk digunakan pada catatan produksi.</p>
    </div>

    @include('jenis-produksi._form', [
        'action' => url('/jenis-produksi'),
        'isEdit' => false,
    ])
@endsection
</div>
