@extends('admin.layouts.base')
@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail Pesanan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">

            <p><strong>Pelanggan:</strong> {{ $order->user->name ?? '-' }}</p>
            <p><strong>No. WA:</strong> {{ $order->no_wa ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $order->alamat ?? '-' }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_harga,0,',','.') }}</p>
            <p><strong>Status Pesanan:</strong> <span class="badge 
                @if($order->status=='pending') bg-warning
                @elseif($order->status=='diproses') bg-primary
                @elseif($order->status=='selesai') bg-success
                @else bg-danger @endif">{{ ucfirst($order->status) }}</span></p>

            <p><strong>Status Pembayaran:</strong>
                <span class="badge {{ $order->payment_status=='paid' ? 'bg-success':'bg-secondary' }}">
                    {{ ucfirst($order->payment_status) ?? 'pending' }}
                </span>
            </p>

            <hr>

            <h5>Daftar Produk</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ optional($item->product)->nama_produk ?? '-' }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>Rp {{ number_format($item->harga,0,',','.') }}</td>
                            <td>Rp {{ number_format($item->harga*$item->qty,0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            @if($order->bukti_payment)
                <p><strong>Bukti Pembayaran:</strong></p>
                <img src="{{ asset('storage/bukti_payment/'.$order->bukti_payment) }}" class="img-fluid mb-3" style="max-width:300px;">
                @if($order->payment_status != 'paid')
                <form action="{{ route('admin.orders.approvePayment', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Konfirmasi Pembayaran</button>
                </form>
                @endif
            @else
                <p class="text-muted">Belum ada bukti pembayaran diunggah.</p>
            @endif

        </div>
    </div>

</div>
@endsection
