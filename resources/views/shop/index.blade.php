@extends('layouts.app')

@section('title', 'Katalog Produk Kayu')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Katalog Produk Kayu</h2>

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('shop.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
            <button class="btn btn-success" type="submit">Cari</button>
        </div>
    </form>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm border-success">
                    @if($product->gambar)
                        <img src="{{ asset('uploads/products/'.$product->gambar) }}" class="card-img-top" height="200">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top">
                    @endif

                    <div class="card-body bg-white">
                        <h5 class="card-title">{{ $product->nama_produk }}</h5>
                        <p class="text-muted">{{ $product->jenis_kayu }}</p>
                    </div>

                    <div class="card-footer text-center bg-white">
                        <a href="{{ route('shop.show', $product->id) }}" class="btn btn-yellow w-100">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Produk tidak ditemukan.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .btn-yellow {
        background-color: #FFD700;
        color: #000;
        border: 1px solid #FFD700;
        transition: 0.3s;
    }
    .btn-yellow:hover {
        background-color: #FFC200;
        color: #000;
    }
    .card.border-success {
        border-width: 2px;
    }
    .card-body, .card-footer {
        background-color: #fff;
    }
</style>
@endsection
