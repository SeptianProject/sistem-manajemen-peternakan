<div>
@extends('layouts.app')

@section('title', 'Catatan Produksi')
@section('topbar-title', 'Catatan Produksi')

@section('content')
    {{-- Data contoh. Nanti dari controller: kirim $produksiList, $totalProduksi, $q --}}
    @php
        $produksiList = $produksiList ?? collect([
            (object) ['id_produksi' => 1, 'tgl_produksi' => '2026-03-09', 'kode_ternak' => 'TRN-001', 'nama_jenis' => 'Sapi Perah', 'nama_produksi' => 'Susu', 'satuan' => 'Liter', 'jumlah_produksi' => 18.5],
            (object) ['id_produksi' => 2, 'tgl_produksi' => '2026-03-08', 'kode_ternak' => 'TRN-002', 'nama_jenis' => 'Ayam Petelur', 'nama_produksi' => 'Telur', 'satuan' => 'Butir', 'jumlah_produksi' => 24],
            (object) ['id_produksi' => 3, 'tgl_produksi' => '2026-03-07', 'kode_ternak' => 'TRN-003', 'nama_jenis' => 'Domba', 'nama_produksi' => 'Wol', 'satuan' => 'Kg', 'jumlah_produksi' => 2.75],
        ]);
        $totalProduksi = $totalProduksi ?? $produksiList->count();
        $q = $q ?? request('q', '');
    @endphp

    <div class="list-header">
        <div>
            <h2>Catatan Produksi</h2>
            <p style="margin:4px 0 0;font-size:13px;color:#7c8493;">Total {{ $totalProduksi }} catatan produksi</p>
        </div>
        <a href="{{ url('client/dashboard/catatan-produksi/create') }}" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Tambah Catatan</a>
    </div>

    <div class="card-panel" style="margin-bottom:0">
        <form method="GET" action="{{ url('client/dashboard/catatan-produksi') }}" class="table-toolbar">
            <div class="search-box"><i class="bi bi-search"></i><input type="text" name="q" value="{{ $q }}" placeholder="Cari ternak atau jenis produksi..." /></div>
            <button type="submit" class="btn-secondary-custom">Cari</button>
        </form>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Ternak</th>
                        <th>Jenis Produksi</th>
                        <th>Jumlah</th>
                        <th style="text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produksiList as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_produksi)->format('d M Y') }}</td>
                            <td><strong>{{ $item->kode_ternak }}</strong><br /><span style="font-size:12px;color:#7c8493;">{{ $item->nama_jenis }}</span></td>
                            <td>{{ $item->nama_produksi }}<br /><span style="font-size:12px;color:#7c8493;">{{ $item->satuan }}</span></td>
                            <td>{{ $item->jumlah_produksi }}</td>
                            <td style="text-align:center;">
                                <div style="display:flex;gap:6px;justify-content:center;">
                                    <a href="{{ url('client/dashboard/catatan-produksi/' . $item->id_produksi . '/edit') }}" class="action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ url('client/dashboard/catatan-produksi/' . $item->id_produksi) }}" style="margin:0;" onsubmit="return confirm('Hapus catatan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:20px;color:#7c8493;">Belum ada data catatan produksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
</div>
