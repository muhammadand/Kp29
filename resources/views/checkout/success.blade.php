@extends('layouts.app')

@section('title', 'Checkout Berhasil')

@section('content')
<div class="container py-4">

    {{-- ✅ Alert Success & Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ✅ Judul & Informasi Order --}}
    <h2 class="mb-4 text-success fw-bold">Pesanan Berhasil!</h2>
    <p>Terima kasih, pesanan Anda telah berhasil dibuat.</p>

    @isset($order)
        <div class="border rounded p-3 mb-3 bg-light">
            <p><strong>No. Order:</strong> {{ $order->id }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
            <p><strong>Status Pembayaran:</strong> 
                <span class="badge 
                    @if($order->payment_status == 'uploaded') bg-warning 
                    @elseif($order->payment_status == 'approved') bg-success 
                    @else bg-secondary @endif">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </p>
        </div>

        {{-- ✅ Form Upload Bukti Pembayaran --}}
        @if($order->payment_status == 'pending')
            <form action="{{ route('checkout.uploadPayment.post', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="bukti_payment" class="form-label">Upload Bukti Pembayaran1</label>
                    <input type="file" name="bukti_payment" id="bukti_payment" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        @else
            <div class="alert alert-info mt-3">
                Bukti pembayaran sudah diunggah. Tunggu konfirmasi admin.
            </div>
        @endif
    @else
        <div class="alert alert-danger mt-4">
            Data pesanan tidak ditemukan.
        </div>
    @endisset

    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
</div>
@endsection
