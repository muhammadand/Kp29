@extends('layouts.app')

@section('title', $product->nama_produk)

@section('content')
<div class="container py-4">
    <div class="row">
        {{-- Gambar Produk --}}
        <div class="col-md-5">
            @if($product->gambar)
                <img src="{{ asset('uploads/products/'.$product->gambar) }}" class="img-fluid rounded shadow">
            @else
                <img src="https://via.placeholder.com/400x400" class="img-fluid rounded shadow">
            @endif
        </div>

        {{-- Detail Produk --}}
        <div class="col-md-7">
            <h2>{{ $product->nama_produk }}</h2>
            <p class="text-muted mb-1">{{ $product->jenis_kayu }}</p>
            <p>{{ $product->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

            <hr>

            <h5 class="mb-3">Varian Produk:</h5>

            @if($product->variants->isEmpty())
                <p class="text-muted">Belum ada varian tersedia.</p>
            @else
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Ukuran</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->variants as $variant)
                            <tr>
                                <td>{{ $variant->ukuran }}</td>
                                <td>{{ $variant->stok }}</td>
                                <td>Rp {{ number_format($variant->harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('cart.add', $variant->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">+ Keranjang</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
