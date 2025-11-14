@extends('admin.layouts.base')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">📦 Daftar Produk</h5>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-light btn-sm fw-semibold">
                        + Tambah Produk
                    </a>
                </div>

                <div class="card-body px-4 pb-4">

                    {{-- Form Pencarian --}}
                    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3 d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..."
                               value="{{ request('search') }}">
                        <button class="btn btn-primary">Cari</button>
                    </form>

                    {{-- Pesan sukses --}}
                    @if(session('success'))
                        <div class="alert alert-success shadow-sm fade show rounded-3" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Jika tidak ada produk --}}
                    @if($products->isEmpty())
                        <div class="text-center text-muted py-4">
                            <p class="mb-0">Belum ada produk yang ditambahkan.</p>
                        </div>
                    @else
                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th style="width:50px">No</th>
                                        <th>Nama Produk</th>
                                        <th>Jenis Kayu</th>
                                        <th>Varian</th>
                                        <th>Gambar</th>
                                        <th style="width: 150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $i => $product)
                                        <tr>
                                            <td>{{ $products->firstItem() + $i }}</td>
                                            <td class="fw-semibold">{{ $product->nama_produk }}</td>
                                            <td>{{ $product->jenis_kayu }}</td>

                                            <td class="text-start">
                                                @if($product->variants->isNotEmpty())
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($product->variants as $variant)
                                                            <li class="mb-1">
                                                                <strong>{{ $variant->ukuran }}</strong> — 
                                                                Stok: {{ $variant->stok }},
                                                                Harga: Rp {{ number_format($variant->harga, 0, ',', '.') }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">Tidak ada varian</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if($product->gambar)
                                                    <img src="{{ asset('uploads/products/'.$product->gambar) }}" width="65"
                                                         class="rounded shadow-sm border">
                                                @else
                                                    <span class="text-muted">Tidak ada</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                   class="btn btn-warning btn-sm mb-1 w-100">
                                                    ✏️ Edit
                                                </a>

                                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                      method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                                        🗑️ Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-end mt-3">
                            {{ $products->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .table th {
        font-weight: 600;
    }

    /* Hover efek lebih elegan */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    /* Tombol aksi */
    .btn-sm {
        font-size: 0.85rem;
    }

    /* Form pencarian */
    form input.form-control {
        border-radius: 0.375rem;
    }

    form button.btn {
        border-radius: 0.375rem;
    }
</style>
@endsection
