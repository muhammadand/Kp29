@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center text-success">Pesanan Saya</h2>

        @if ($orders->isEmpty())
            <div class="alert alert-warning text-center">
                Anda belum memiliki pesanan.
            </div>
        @else
            <div class="row">
                @foreach ($orders as $order)
                    <div class="col-md-6 mb-4">
                        <div class="card border-success shadow-sm">
                            <div class="card-header bg-white">
                                <strong>Order #{{ $order->id }}</strong> -
                                <span class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</span>
                            </div>

                            <div class="card-body bg-white">
                                <p><strong>Nama Pelanggan:</strong> {{ $order->nama_pelanggan }}</p>
                                @php
                                    $uniqueProducts = $order->items->pluck('product.nama_produk')->unique()->filter();
                                @endphp

                                <p><strong>Produk:</strong> {{ $uniqueProducts->join(', ') }}</p>

                                <p><strong>Alamat:</strong> {{ $order->alamat }}</p>
                                <p><strong>Status pembayaran:</strong> {{ $order->payment_status }}</p>

                                <p><strong>Status:</strong>
                                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>

                                <hr>

                                <h6>Item Pesanan:</h6>

                                @if ($order->Items && $order->Items->count())
                                    <ul class="list-group list-group-flush">
                                        @foreach ($order->Items as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $item->product->variants->first()->ukuran ?? 'Tidak ada varian' }}
                                                x {{ $item->qty }}
                                                <span>Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">Tidak ada item pada order ini.</p>
                                @endif

                                <hr>

                                <p class="text-end">
                                    <strong>Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                                </p>
                            </div>

                            <div class="card-footer text-center bg-white">

                                <a href="{{ route('checkout.success', $order->id) }}" class="btn btn-yellow w-100 mb-2">
                                    Lihat Detail
                                </a>

                                {{-- Tombol Rating pakai modal --}}
                                @if ($order->status === 'selesai')
                                    <button class="btn btn-success w-100" data-bs-toggle="modal"
                                        data-bs-target="#reviewModal{{ $order->id }}">
                                        Beri Rating & Testimoni
                                    </button>
                                @endif

                            </div>

                        </div>
                    </div>

                    {{-- ========================= --}}
                    {{-- MODAL TESTIMONI PER ORDER --}}
                    {{-- ========================= --}}

                    <div class="modal fade" id="reviewModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="{{ route('review.store', $order->id) }}" method="POST">
                                @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Beri Rating & Testimoni</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        {{-- Nama user --}}
                                        <div class="mb-3">
                                            <label class="form-label">Nama Anda</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>

                                        <hr>
                                        <h6>Rating untuk Produk:</h6>

                                        @php
                                            // Ambil produk unik hanya berdasarkan product_id
                                            $uniqueItems = $order->Items->unique('product_id');
                                        @endphp

                                        @foreach ($uniqueItems as $item)
                                            <div class="border rounded p-3 mb-3">
                                                <strong>{{ $item->product->nama_produk }}</strong>

                                                {{-- Rating --}}
                                                <div class="mt-2">
                                                    <label>Rating (1–5)</label>
                                                    <select name="rating[{{ $item->product_id }}]" class="form-select"
                                                        required>
                                                        <option value="">Pilih rating...</option>
                                                        <option value="1">1 - Buruk</option>
                                                        <option value="2">2 - Cukup</option>
                                                        <option value="3">3 - Bagus</option>
                                                        <option value="4">4 - Sangat Bagus</option>
                                                        <option value="5">5 - Luar Biasa</option>
                                                    </select>
                                                </div>

                                                {{-- Testimoni --}}
                                                <div class="mt-2">
                                                    <label>Testimoni</label>
                                                    <textarea name="content[{{ $item->product_id }}]" class="form-control" rows="3" required></textarea>
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            Kirim Rating
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        /* Tombol kuning */
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

        .card-body,
        .card-header,
        .card-footer {
            background-color: #fff;
        }
    </style>
@endsection
