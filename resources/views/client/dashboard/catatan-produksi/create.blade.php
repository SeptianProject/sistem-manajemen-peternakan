<div>
@extends('layouts.app')
 
@section('title', 'Tambah Catatan Produksi')
@section('topbar-title', 'Tambah Catatan Produksi')
 
@section('content')
    <div class="page-header">
        <h1>Tambah Catatan Produksi Baru</h1>
        <p>Rekam hasil produksi per ternak dan jenis produksi.</p>
    </div>
 
    @include('catatan-produksi._form', [
        'action' => url('/catatan-produksi'),
        'isEdit' => false,
    ])
@endsection
 </div>
