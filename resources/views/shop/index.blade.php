@extends('layouts.app')

@section('title', 'Katalog Produk Kayu')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Katalog Produk Kayu</h2>

    <!-- Form Pencarian & Filter -->
    <form method="GET" action="{{ route('shop.index') }}" class="mb-4">

        <div class="row g-2">

            <!-- Input Search -->
            <div class="col-md-6">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control" 
                    placeholder="Cari produk..." 
                    value="{{ request('search') }}"
                >
            </div>

            <!-- Dropdown Jenis Kayu -->
            <div class="col-md-4">
                <select name="jenis_kayu" class="form-select">
                    <option value="">Semua Jenis Kayu</option>

                    @foreach($jenisKayuList as $jenis)
                        <option value="{{ $jenis }}"
                            {{ request('jenis_kayu') == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol -->
            <div class="col-md-2">
                <button class="btn btn-success w-100" type="submit">Filter</button>
            </div>

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

                        <!-- Jenis Kayu -->
                        <span class="badge bg-warning text-dark">
                            {{ $product->jenis_kayu }}
                        </span>
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
</style>
@endsection
