@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Keranjang Belanja</h2>

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
                    <th>Total</th>
                    <th></th>
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
                        <td>{{ $item['ukuran'] }}</td>
                        <td>Rp {{ number_format($item['harga'],0,',','.') }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                @csrf
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control form-control-sm" style="width:70px;">
                                <button class="btn btn-sm btn-success ms-2">Update</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($subtotal,0,',','.') }}</td>
                        <td>
                            <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-danger">X</a>
                        </td>
                    </tr>
                @endforeach
                <tr class="table-warning">
                    <td colspan="4" class="text-end"><strong>Total Belanja:</strong></td>
                    <td colspan="2"><strong>Rp {{ number_format($total,0,',','.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        @if(Auth::check())
            <a href="{{ route('checkout.index') }}" class="btn btn-primary mb-3">Lanjut Checkout</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-warning w-100 mt-3">Login untuk Checkout</a>
        @endif
    @endif
</div>
@endsection
