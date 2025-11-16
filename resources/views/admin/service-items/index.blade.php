@extends('admin.layouts.base')

@section('title', 'Data Item Layanan')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Kelola Item Layanan</h3>

        <a href="{{ route('admin.service-items.create') }}" class="btn btn-primary">
            + Tambah Item
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Item Layanan</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-primary">
                    <tr>
                        <th width="10%">Gambar</th>
                        <th width="20%">Kategori</th>
                        <th width="25%">Nama Item</th>
                        <th width="15%">Harga</th>
                        <th width="10%">Unit</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            {{-- Gambar --}}
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" 
                                         alt="Gambar {{ $item->name }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 80px;">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>

                            {{-- Kategori --}}
                            <td>{{ $item->category->name }}</td>

                            {{-- Nama Item --}}
                            <td>{{ $item->name }}</td>

                            {{-- Harga --}}
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>

                            {{-- Unit --}}
                            <td>{{ $item->unit ?? '-' }}</td>

                            {{-- Aksi --}}
                            <td>
                                <a href="{{ route('admin.service-items.edit', $item->id) }}" 
                                   class="btn btn-sm btn-primary mb-1">
                                    Edit
                                </a>

                                <form action="{{ route('admin.service-items.destroy', $item->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Belum ada item layanan ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
