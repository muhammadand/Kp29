@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Checkout</h2>

    @if(empty($cart))
        <p class="text-center text-muted">Keranjang masih kosong.</p>
        <a href="{{ route('cart.index') }}" class="btn btn-secondary mt-3">Kembali ke Keranjang</a>
    @else
        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php
                        $subtotal = $item['harga'] * $item['qty'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item['nama_produk'] }}</td>
                        <td>Rp {{ number_format($item['harga'],0,',','.') }}</td>
                        <td>{{ $item['qty'] }}</td>
                        <td>Rp {{ number_format($subtotal,0,',','.') }}</td>
                    </tr>
                @endforeach
                <tr class="table-warning">
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td><strong>Rp {{ number_format($total,0,',','.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="no_wa" class="form-label">No. WhatsApp</label>
                <input type="text" name="no_wa" id="no_wa" class="form-control" value="{{ old('no_wa') }}" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success w-100">Proses Checkout</button>
        </form>
    @endif
</div>
@endsection
