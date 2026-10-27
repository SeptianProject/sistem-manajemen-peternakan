<div>
    @extends('layouts.app')

@section('title', 'Edit Catatan Produksi')
@section('topbar-title', 'Edit Catatan Produksi')

@section('content')
    {{-- Data contoh. Nanti dari controller: kirim $item --}}
    @php
        $item = $item ?? (object) [
            'id_produksi' => $id ?? 1,
            'id_ternak' => 1,
            'id_jenis_produksi' => 1,
            'tgl_produksi' => '2026-03-09',
            'jumlah_produksi' => 18.5,
        ];
    @endphp

    <div class="page-header">
        <h1>Edit Catatan Produksi</h1>
        <p>Perbarui data produksi ternak.</p>
    </div>

    @include('catatan-produksi._form', [
        'action' => url('/catatan-produksi/' . $item->id_produksi),
        'isEdit' => true,
    ])
@endsection
</div>