@extends('admin.layouts.base')

@section('title', 'Data Order Layanan')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold text-primary mb-4">Kelola Order Layanan</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Order Layanan</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama Customer</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th>Item Layanan</th>
                        <th>Total Harga</th>
                        <th>Status Order</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->item->name ?? '-' }}</td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($order->order_status) }}</td>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                            <td>
                                <a href="{{ route('admin.service-orders.show', $order->id) }}" class="btn btn-sm btn-info mb-1">Detail</a>

                                {{-- Update status order --}}
                                <form action="{{ route('admin.service-orders.updateOrderStatus', $order->id) }}" method="POST" class="mb-1">
                                    @csrf
                                    @method('PUT')
                                    <select name="order_status" class="form-select form-select-sm mb-1">
                                        @foreach(['pending','processing','completed','canceled'] as $status)
                                            <option value="{{ $status }}" {{ $order->order_status == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Belum ada order layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3 px-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
