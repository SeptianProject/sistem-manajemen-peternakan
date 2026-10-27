@extends('modules.dashboard.layouts.app')

@section('title', ($item ? 'Edit ' : 'Tambah ').$label)
@section('eyebrow', 'Manajemen Data')
@section('heading', ($item ? 'Edit ' : 'Tambah ').$label)

@section('content')
    <section class="dashboard-panel">
        <form method="post" action="{{ $item ? route('management.'.$resource.'.update', $item->id) : route('management.'.$resource.'.store') }}">
            @csrf
            @if ($item) @method('PUT') @endif
            <div class="row g-3">
                @foreach ($fields as $field)
                    @php
                        $value = old($field, $item?->{$field});
                        $options = match ($field) {
                            'client_id' => $clients,
                            'ternak_id' => $ternak,
                            'kandang_id' => $kandang,
                            'petugas_id' => $petugas,
                            'jenis_ternak_id' => $jenisTernak,
                            'jenis_produksi_id' => $jenisProduksi,
                            'tindakan_id' => $tindakan,
                            'jabatan_id' => $jabatan,
                            'user_id' => $users,
                            default => null,
                        };
                    @endphp
                    <div class="col-md-6">
                        <label class="form-label" for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        @if ($options)
                            <select class="form-select @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}">
                                <option value="">Pilih...</option>
                                @foreach ($options as $option)
                                    <option value="{{ $option->id }}" @selected((string) $value === (string) $option->id)>{{ $option->nama ?? $option->nama_peternakan ?? $option->id }}</option>
                                @endforeach
                            </select>
                        @elseif (in_array($field, ['diagnosa']))
                            <textarea class="form-control @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}">{{ $value }}</textarea>
                        @elseif ($field === 'password')
                            <input type="password" class="form-control @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}" @required(!$item)>
                        @elseif (in_array($field, ['status', 'role', 'jenis_kelamin']))
                            <select class="form-select @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}">
                                @foreach (match ($field) { 'status' => ($resource === 'ternak' ? ['aktif','terjual','mati'] : ['aktif','nonaktif']), 'role' => ['admin','pemilik','petugas'], default => ['jantan','betina'] } as $option)
                                    <option value="{{ $option }}" @selected($value === $option)>{{ ucfirst($option) }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="{{ str_contains($field, 'tgl_') ? 'date' : (in_array($field, ['jumlah','kapasitas','suhu_min','suhu_max','berat_badan','suhu_badan']) ? 'number' : 'text') }}" step="0.01" class="form-control @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}" value="{{ $value }}">
                        @endif
                        @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                @endforeach
            </div>
            <div class="mt-4"><button class="btn btn-primary">Simpan</button> <a href="{{ route('management.'.$resource.'.index') }}" class="btn btn-light">Batal</a></div>
        </form>
    </section>
@endsection
