@extends('layouts.app')

@section('title', 'Checkout Jasa')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    <h3 class="fw-bold text-primary mb-4">Checkout Jasa</h3>

                    <!-- Info layanan -->
                    <div class="mb-4 p-3 bg-light rounded-4 border">
                        <h5 class="fw-bold mb-1">{{ $service->name }}</h5>
                        <p class="text-muted m-0">
                            Harga per {{ $service->unit }}:  
                            <strong class="text-success">Rp {{ number_format($service->price, 0, ',', '.') }}</strong>
                        </p>
                    </div>

                    <!-- FORM START -->
                    <form action="{{ route('shop.services.order.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="service_item_id" value="{{ $service->id }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pemesan</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp / Telepon</label>
                            <input type="text" name="customer_phone" class="form-control" placeholder="Contoh: 08123456789" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan (Opsional)</label>
                            <textarea name="note" class="form-control" rows="2" placeholder="Misal: ukuran khusus, permintaan tambahan"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah ({{ $service->unit }})</label>
                            <input type="number" name="quantity" class="form-control" min="1" required>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fs-5">
                            Lanjutkan ke Pembayaran
                        </button>
                    </form>
                    <!-- FORM END -->

                    <a href="{{ route('shop.services') }}" 
                       class="btn btn-outline-primary w-100 rounded-pill py-2 mt-3">
                        Kembali ke Daftar Jasa
                    </a>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
