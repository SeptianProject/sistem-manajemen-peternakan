@extends('modules.dashboard.layouts.app')

@section('title', $label)
@section('eyebrow', 'Manajemen Data')
@section('heading', $label)
@section('description', 'Kelola data '.$label.' dengan aman dan terstruktur.')

@section('content')
    <section class="dashboard-panel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 mb-0">{{ $label }}</h2>
            <a href="{{ route('management.'.$resource.'.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
        </div>
        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>ID</th><th>Data</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ collect($item->getAttributes())->except(['id', 'client_id', 'created_at', 'updated_at', 'password'])->map(fn ($value, $key) => ucfirst(str_replace('_', ' ', $key)).': '.$value)->implode(' · ') }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('management.'.$resource.'.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('management.'.$resource.'.destroy', $item->id) }}" method="post" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </section>
@endsection
