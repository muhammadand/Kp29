@extends('layouts.app')

@section('title', 'Checkout Layanan')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="row g-0">

                    <!-- LEFT: FORM -->
                    <div class="col-lg-7 p-5">

                        <h3 class="fw-bold mb-4 text-primary">Checkout Layanan</h3>

                        <form action="{{ route('shop.services.order.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="service_item_id" value="{{ $service->id }}">
                            <input type="hidden" id="price" value="{{ $service->price }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Pemesan</label>
                                <input type="text" name="customer_name" class="form-control form-control-lg" value="{{ auth()->user()->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nomor WhatsApp</label>
                                <input type="text" name="customer_phone" class="form-control form-control-lg" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat Lengkap</label>
                                <textarea name="address" rows="3" class="form-control form-control-lg" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Catatan Tambahan</label>
                                <textarea name="note" rows="2" class="form-control form-control-lg"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Jumlah</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control form-control-lg" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">
                                Buat Pesanan
                            </button>
                        </form>
                    </div>

                    <!-- RIGHT: SUMMARY -->
                    <div class="col-lg-5 bg-light p-5">
                        <h4 class="fw-bold text-dark mb-4">Ringkasan Pesanan</h4>

                        <div class="d-flex mb-3">
                            <div class="flex-grow-1">
                                <h5 class="fw-semibold mb-1">{{ $service->name }}</h5>
                                <p class="text-muted mb-0">{{ $service->category->name }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Harga per unit</span>
                            <strong>Rp {{ number_format($service->price, 0, ',', '.') }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Jumlah</span>
                            <strong id="showQuantity">1</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bold">Total Harga</h5>
                            <h5 class="fw-bold text-success" id="totalPrice">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </h5>
                        </div>

                        <p class="text-muted mt-3 small">
                            Pesanan Anda akan diproses setelah admin mengonfirmasi pembayaran.
                        </p>

                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
    const quantityInput = document.getElementById("quantity");
    const showQuantity = document.getElementById("showQuantity");
    const totalPriceText = document.getElementById("totalPrice");
    const price = parseInt(document.getElementById("price").value);

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    quantityInput.addEventListener("input", function () {
        let qty = parseInt(quantityInput.value);
        if (qty < 1) qty = 1;

        showQuantity.textContent = qty;
        totalPriceText.textContent = "Rp " + formatRupiah(price * qty);
    });
</script>
@endsection
