@extends('admin.layouts.base')
@section('title', 'Laporan Transaksi')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Transaksi</h6>
    </div>

    <div class="card-body">
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <select name="periode" class="form-control" onchange="this.form.submit()">
                        <option value="harian" {{ $periode=='harian' ? 'selected' : '' }}>Harian (Hari ini)</option>
                        <option value="mingguan" {{ $periode=='mingguan' ? 'selected' : '' }}>Mingguan (minggu ini)</option>
                        <option value="bulanan" {{ $periode=='bulanan' ? 'selected' : '' }}>Bulanan (bulan ini)</option>
                        <option value="custom" {{ $periode=='custom' ? 'selected' : '' }}>Custom Range</option>
                    </select>
                </div>

                @if ($periode == 'custom')
                <div class="col-md-3">
                    <input type="date" name="start" class="form-control" value="{{ request('start') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="end" class="form-control" value="{{ request('end') }}">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>
                @endif
            </div>
        </form>

        <h5>Total Pendapatan: <strong>Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</strong></h5>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->nama_pelanggan }}</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
