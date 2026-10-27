<div>
@extends('layouts.app')

@section('title', 'Jenis Produksi')
@section('topbar-title', 'Jenis Produksi')

@section('content')
    {{-- Data contoh. Nanti dari controller: kirim $jenisProduksiList, $totalJenisProduksi, $q --}}
    @php
        $jenisProduksiList = $jenisProduksiList ?? collect([
            (object) ['id_jenis_produksi' => 1, 'nama_produksi' => 'Susu', 'satuan' => 'Liter'],
            (object) ['id_jenis_produksi' => 2, 'nama_produksi' => 'Telur', 'satuan' => 'Butir'],
            (object) ['id_jenis_produksi' => 3, 'nama_produksi' => 'Wol', 'satuan' => 'Kg'],
        ]);
        $totalJenisProduksi = $totalJenisProduksi ?? $jenisProduksiList->count();
        $q = $q ?? request('q', '');
    @endphp

    <div class="list-header">
        <div>
            <h2>Daftar Jenis Produksi</h2>
            <p style="margin:4px 0 0;font-size:13px;color:#7c8493;">Total {{ $totalJenisProduksi }} jenis produksi terdaftar</p>
        </div>
        <a href="{{ url('/jenis-produksi/create') }}" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Tambah Jenis</a>
    </div>

    <div class="card-panel" style="margin-bottom:0">
        <form method="GET" action="{{ url('/jenis-produksi') }}" class="table-toolbar">
            <div class="search-box"><i class="bi bi-search"></i><input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau satuan..." /></div>
            <button type="submit" class="btn-secondary-custom">Cari</button>
        </form>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Jenis Produksi</th>
                        <th>Satuan</th>
                        <th style="text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenisProduksiList as $jenis)
                        <tr>
                            <td>{{ $jenis->nama_produksi }}</td>
                            <td>{{ $jenis->satuan }}</td>
                            <td style="text-align:center;">
                                <div style="display:flex;gap:6px;justify-content:center;">
                                    <a href="{{ url('/jenis-produksi/' . $jenis->id_jenis_produksi . '/edit') }}" class="action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ url('/jenis-produksi/' . $jenis->id_jenis_produksi) }}" style="margin:0;" onsubmit="return confirm('Hapus jenis produksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center;padding:20px;color:#7c8493;">Belum ada data jenis produksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
</div>
