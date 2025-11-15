@extends('layouts.app')

@section('title', $product->nama_produk)

@section('content')
    <div class="container py-4">
        <div class="row">

            {{-- Gambar Produk --}}
            <div class="col-md-5">
                @if ($product->gambar)
                    <img src="{{ asset('uploads/products/' . $product->gambar) }}" class="img-fluid rounded shadow">
                @else
                    <img src="https://via.placeholder.com/400x400" class="img-fluid rounded shadow">
                @endif
            </div>

            {{-- Detail Produk --}}
            <div class="col-md-7">

                {{-- Nama Produk --}}
                <h2>{{ $product->nama_produk }}</h2>

                {{-- ⭐ Rating Produk --}}
                @if ($product->reviews->count() > 0)
                    <div class="mb-2">

                        {{-- Rata-rata rating --}}
                        <strong>{{ number_format($product->reviews->avg('rating'), 1) }}</strong>

                        @php
                            $avg = round($product->reviews->avg('rating')); // bulatkan 1–5
                        @endphp

                        {{-- Bintang --}}
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $avg)
                                <span style="color: gold; font-size: 18px;">★</span>
                            @else
                                <span style="color: #ccc; font-size: 18px;">★</span>
                            @endif
                        @endfor

                        <small class="text-muted">({{ $product->reviews->count() }} ulasan)</small>
                    </div>
                @else
                    <div class="mb-2 text-muted">
                        ⭐ Belum ada rating
                    </div>
                @endif

                {{-- Jenis Kayu --}}
                <p class="text-muted mb-1">{{ $product->jenis_kayu }}</p>

                {{-- Deskripsi --}}
                <p>{{ $product->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                <hr>

                {{-- VARIAN PRODUK --}}
                <h5 class="mb-3">Varian Produk:</h5>

                @if ($product->variants->isEmpty())
                    <p class="text-muted">Belum ada varian tersedia.</p>
                @else
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Ukuran</th>
                                <th>Stok</th>
                                <th>Harga satuan</th>
                                <th>Harga/m3</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->variants as $variant)
                                <tr>
                                    <td>{{ $variant->ukuran }}</td>
                                    <td>{{ $variant->stok }}</td>
                                    <td>Rp {{ number_format($variant->harga, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($variant->harga_m3, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.add', $variant->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">+ Keranjang</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>


        {{-- ==== DAFTAR ULASAN / TESTIMONI ==== --}}
        <hr class="my-4">
        <h4 class="mb-3">Ulasan Pembeli</h4>

        @if ($product->reviews->isEmpty())
            <p class="text-muted">Belum ada ulasan.</p>
        @else
            @foreach ($product->reviews as $review)
                <div class="border rounded p-3 mb-3">

                    {{-- Nama --}}
                    <strong>{{ $review->name }}</strong>

                    {{-- Bintang tiap review --}}
                    <div>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <span style="color: gold;">★</span>
                            @else
                                <span style="color: #ccc;">★</span>
                            @endif
                        @endfor
                    </div>

                    {{-- Isi testimoni --}}
                    <p class="mt-2 mb-0">{{ $review->content }}</p>

                </div>
            @endforeach
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil menambahkan!',
                html: `
            <p>{{ session('success') }}</p>
            <hr>
            <p>{{ session('product_name') }} dengan {{ session('variant_size') }} harga Rp {{ session('variant_price') }}</p>
        `,
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif
@endsection
