@extends('admin.layouts.base')
@section('title', 'Daftar Pesanan')

@section('content')

{{-- ================= FILTER STATUS ================= --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="fw-semibold mb-1">Filter Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">— Semua Status —</option>
                        <option value="pending"  {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ request('status')=='diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai"  {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal"    {{ request('status')=='batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ================= TABEL PESANAN ================= --}}
<div class="card shadow-lg border-0 rounded-3">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">📦 Daftar Pesanan</h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light btn-sm fw-bold">Refresh</a>
    </div>

    <div class="card-body">

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Total Harga</th>
                        <th>Status Order</th>
                        <th>Status Pembayaran</th>
                        <th>Bukti Pembayaran</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="text-center fw-bold">#{{ $order->id }}</td>

                            <td>{{ $order->user->name ?? 'Pelanggan' }}</td>

                            <td class="fw-semibold text-primary">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>

                            <td class="text-center">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                        <option value="pending"  {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai"  {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="batal"    {{ $order->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </form>
                            </td>

                            <td class="text-center">
                                @if ($order->payment_status == 'pending')
                                    <span class="badge bg-warning px-3 py-2 text-white">Pending</span>
                                @elseif ($order->payment_status == 'uploaded')
                                    <span class="badge bg-success px-3 py-2 text-white">Dibayar</span>
                                @elseif ($order->payment_status == 'ditolak')
                                    <span class="badge bg-danger px-3 py-2">Ditolak</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($order->bukti_payment)
                                    <a href="{{ asset('storage/' . $order->bukti_payment) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->bukti_payment) }}"
                                             class="img-thumbnail shadow-sm"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    </a>
                                @else
                                    <small class="text-muted">Belum diunggah</small>
                                @endif
                            </td>

                            <td class="text-center">
                                {{ $order->created_at->format('d-m-Y H:i') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Tidak ada pesanan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ===== Custom Styling ===== --}}
<style>
    .table th {
        font-weight: 600;
    }
    .badge {
        font-size: 0.85rem;
    }
</style>

@endsection
