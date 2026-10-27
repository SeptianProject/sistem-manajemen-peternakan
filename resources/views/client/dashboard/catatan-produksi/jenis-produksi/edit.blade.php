<div>
    @extends('layouts.app')

@section('title', 'Edit Jenis Produksi')
@section('topbar-title', 'Edit Jenis Produksi')

@section('content')
    {{-- Data contoh. Nanti dari controller: kirim $item --}}
    @php
        $item = $item ?? (object) [
            'id_jenis_produksi' => $id ?? 1,
            'nama_produksi' => 'Susu',
            'satuan' => 'Liter',
        ];
    @endphp

    <div class="page-header">
        <h1>Edit Jenis Produksi</h1>
        <p>Perbarui master data jenis produksi.</p>
    </div>

    @include('jenis-produksi._form', [
        'action' => url('/jenis-produksi/' . $item->id_jenis_produksi),
        'isEdit' => true,
    ])
@endsection
</div>