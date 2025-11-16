@extends('layouts.app')

@section('title', 'Upload Bukti Pembayaran')

@section('content')
<div class="container py-5">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <h3 class="fw-bold text-primary mb-3">Upload Bukti Pembayaran</h3>

            <p class="mb-4">
                Silakan unggah foto bukti pembayaran untuk menyelesaikan pesanan Anda.
            </p>

            @if(session('success'))
                <div class="alert alert-success rounded-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('shop.services.order.send', $order->id) }}" 
                  method="POST" enctype="multipart/form-data">

                @csrf
                 <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div class="mb-3">
                    <label class="form-label">Bukti Pembayaran (JPG/PNG)</label>
                    <input type="file" name="payment_proof" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    Upload Sekarang
                </button>

                <a href="{{ route('shop.services') }}" 
                   class="btn btn-outline-secondary rounded-pill px-4 ms-2">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>
@endsection
