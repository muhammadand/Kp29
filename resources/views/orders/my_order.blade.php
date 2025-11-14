@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center text-success">Pesanan Saya</h2>

    @if($orders->isEmpty())
        <div class="alert alert-warning text-center">
            Anda belum memiliki pesanan.
        </div>
    @else
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-6 mb-4">
                    <div class="card border-success shadow-sm">
                        <div class="card-header bg-white">
                            <strong>Order #{{ $order->id }}</strong> - <span class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="card-body bg-white">
                            <p><strong>Nama Pelanggan:</strong> {{ $order->nama_pelanggan }}</p>
                            <p><strong>Alamat:</strong> {{ $order->alamat }}</p>
                             <p><strong>Status pembayaran:</strong> {{ $order->payment_status}}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>

                            <hr>

                            <h6>Item Pesanan:</h6>
                            @if($order->Items && $order->Items->count())
                                <ul class="list-group list-group-flush">
                                    @foreach($order->Items as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $item->product->nama_produk ?? 'Produk tidak ditemukan' }} x {{ $item->qty }}
                                            <span>Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Tidak ada item pada order ini.</p>
                            @endif

                            <hr>
                            <p class="text-end"><strong>Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></p>
                        </div>
                        <div class="card-footer text-center bg-white">
                            <a href="{{ route('checkout.success', $order->id) }}" class="btn btn-yellow w-100">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    /* Tombol kuning */
    .btn-yellow {
        background-color: #FFD700; /* kuning */
        color: #000;
        border: 1px solid #FFD700;
        transition: 0.3s;
    }
    .btn-yellow:hover {
        background-color: #FFC200;
        color: #000;
    }

    /* Card border hijau */
    .card.border-success {
        border-width: 2px;
    }

    /* Background card */
    .card-body, .card-header, .card-footer {
        background-color: #fff;
    }
</style>
@endsection
