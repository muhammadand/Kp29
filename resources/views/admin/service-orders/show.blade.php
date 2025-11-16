@extends('admin.layouts.base')

@section('title', 'Detail Order Layanan')

@section('content')
<div class="container mt-5">

    <h2 class="fw-bold text-primary mb-4">Detail Order #{{ $order->id }}</h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">

        {{-- Informasi Pemesan --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <strong>Informasi Pemesan</strong>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Alamat:</strong> {{ $order->address }}</p>
                    <p><strong>Catatan:</strong> {{ $order->note ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Informasi Item Layanan --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <strong>Item Layanan</strong>
                </div>
                <div class="card-body">
                    <p><strong>Nama Item:</strong> {{ $order->item->name }}</p>
                    <p><strong>Jumlah:</strong> {{ $order->total_price / $order->item->price }} {{ $order->item->unit ?? '-' }}</p>
                    <p><strong>Total Harga:</strong> <span class="text-success fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
                </div>
            </div>
        </div>

        {{-- Bukti Pembayaran --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <strong>Bukti Pembayaran</strong>
                </div>
                <div class="card-body text-center">
                    @if($order->payment_proof)
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 250px;">
                    @else
                        <p class="text-muted">Belum ada bukti pembayaran</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Status Order & Pembayaran --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <strong>Status Order & Pembayaran</strong>
                </div>
                <div class="card-body">
                    @php
                        $orderStatusClasses = [
                            'pending' => 'badge bg-warning',
                            'processing' => 'badge bg-info',
                            'completed' => 'badge bg-success',
                            'canceled' => 'badge bg-danger',
                        ];
                        $paymentStatusClasses = [
                            'unpaid' => 'badge bg-danger',
                            'waiting_verification' => 'badge bg-warning',
                            'paid' => 'badge bg-success',
                            'rejected' => 'badge bg-secondary',
                        ];
                    @endphp

                    <p>
                        <strong>Status Order:</strong> 
                        <span class="{{ $orderStatusClasses[$order->order_status] ?? 'badge bg-secondary' }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </p>

                    <p class="mt-2">
                        <strong>Status Pembayaran:</strong>
                        <span class="{{ $paymentStatusClasses[$order->payment_status] ?? 'badge bg-secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-4 text-end">
        <a href="{{ route('admin.service-orders.index') }}" class="btn btn-light shadow-sm">Kembali ke Daftar Order</a>
    </div>

</div>
@endsection
