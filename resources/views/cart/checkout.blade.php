@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Checkout</h2>

    @if(empty($cart))
        <p class="text-center text-muted">Keranjang masih kosong.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $variant_id => $item)
                    @php $subtotal = $item['harga'] * $item['qty']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['nama_produk'] }}</td>
                        <td>{{ $item['ukuran'] }}</td>
                        <td>Rp {{ number_format($item['harga'],0,',','.') }}</td>
                        <td>{{ $item['qty'] }}</td>
                        <td>Rp {{ number_format($subtotal,0,',','.') }}</td>
                    </tr>
                @endforeach
                <tr class="table-warning">
                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                    <td><strong>Rp {{ number_format($total,0,',','.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        {{-- ✅ FORM CHECKOUT --}}
        <form action="{{ route('checkout.process') }}" method="POST" class="mt-4">
            @csrf

                       <div class="mb-3">
                <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                <input type="text" name="no_wa" id="no_wa" 
                    class="form-control" 
                    placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" rows="3" 
                    class="form-control" placeholder="Tulis alamat lengkap pengiriman..." required></textarea>
            </div>

            <button type="submit" class="btn btn-success w-100">
                Buat Pesanan
            </button>
        </form>
    @endif
</div>
@endsection
