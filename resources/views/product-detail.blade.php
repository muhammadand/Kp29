@extends('layouts.app')

@section('title', $product->nama_produk)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-5">
            @if($product->gambar)
                <img src="{{ asset('uploads/products/'.$product->gambar) }}" class="img-fluid rounded shadow">
            @else
                <img src="https://via.placeholder.com/400x400?text=No+Image" class="img-fluid rounded shadow">
            @endif
        </div>

        <div class="col-md-7">
            <h2>{{ $product->nama_produk }}</h2>
            <p><strong>Jenis Kayu:</strong> {{ $product->jenis_kayu }}</p>
            <p><strong>Ukuran:</strong> {{ $product->ukuran ?? '-' }}</p>
            <p><strong>Harga:</strong> <span class="text-success">Rp {{ number_format($product->harga,0,',','.') }}</span></p>
            <p><strong>Stok:</strong> {{ $product->stok }}</p>

            <hr>

            @if(Auth::check() && Auth::user()->role == 'pelanggan')
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg mt-3">
                        + Tambah ke Keranjang
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-warning btn-lg mt-3">
                    Login untuk membeli
                </a>
            @endif

        </div>
    </div>
</div>

<style>
    h2 { font-weight: 600; }
    .btn-primary { background-color: #7b4f2b; border: none; }
    .btn-primary:hover { background-color: #5c3b1e; }
    .btn-warning { border: none; }
</style>
@endsection
