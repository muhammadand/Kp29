@extends('admin.layouts.base')

@section('title', 'Kategori Layanan')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Kategori Layanan</h3>

        <a href="{{ route('admin.service-categories.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Kategori Layanan</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-primary">
                    <tr>
                        <th width="15%">Gambar</th>
                        <th width="30%">Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            {{-- Gambar --}}
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         alt="Gambar {{ $category->name }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 80px;">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td class="fw-bold">{{ $category->name }}</td>

                            {{-- Deskripsi --}}
                            <td>{{ $category->description }}</td>

                            {{-- Aksi --}}
                            <td>
                                <a href="{{ route('admin.service-categories.edit', $category->id) }}"
                                    class="btn btn-sm btn-primary mb-1">
                                    Edit
                                </a>

                                <form action="{{ route('admin.service-categories.destroy', $category->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3 px-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
