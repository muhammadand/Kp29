<table class="table table-bordered table-hover align-middle">
    <thead class="thead-dark text-center">
        <tr>
            <th style="width: 70px;">ID</th>
            <th>Pelanggan</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th style="width: 120px;">Aksi</th>
        </tr>
    </thead>

    <tbody>
    @forelse ($orders as $order)
        <tr>
            <td class="text-center">#{{ $order->id }}</td>

            <td>{{ $order->user->name ?? 'User Terhapus' }}</td>

            {{-- Gunakan total_harga atau total_price tergantung nama kolom yang ada --}}
            <td class="text-end">
                Rp {{ number_format($order->total_harga ?? $order->total_price ?? 0, 0, ',', '.') }}
            </td>

            <td class="text-center">
                @switch($order->status)
                    @case('diproses')
                        <span class="badge bg-primary px-3 py-2 text-uppercase">Diproses</span>
                        @break
                    @case('selesai')
                        <span class="badge bg-success px-3 py-2 text-uppercase">Selesai</span>
                        @break
                    @case('batal')
                        <span class="badge bg-danger px-3 py-2 text-uppercase">Batal</span>
                        @break
                    @default
                        <span class="badge bg-secondary px-3 py-2 text-uppercase">Tidak Diketahui</span>
                @endswitch
            </td>

            <td class="text-center">
                {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
            </td>

            <td class="text-center">
                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info rounded-pill">
                    <i class="fas fa-eye"></i> Detail
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted py-4">
                Belum ada pesanan pada status ini.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
