@extends('layouts.app')

@section('title', $product->nama_produk)

@section('content')
    <div class="container py-5">

        {{-- Product Detail Section --}}
        <div class="row g-4 mb-5">

            {{-- Gambar Produk --}}
            <div class="col-lg-5 col-md-6">
                <div class="position-sticky" style="top: 20px;">
                    <div class="rounded-3 overflow-hidden" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        @if ($product->gambar)
                            <img src="{{ asset('uploads/products/' . $product->gambar) }}" class="img-fluid w-100"
                                alt="{{ $product->nama_produk }}" style="object-fit: cover; max-height: 500px;">
                        @else
                            <img src="https://via.placeholder.com/500x500?text=No+Image" class="img-fluid w-100"
                                alt="No Image" style="object-fit: cover; max-height: 500px;">
                        @endif
                    </div>
                </div>
            </div>

            {{-- Detail Produk --}}
            <div class="col-lg-7 col-md-6">

                {{-- Breadcrumb / Kategori --}}
                <div class="mb-2">
                    <span class="badge bg-light text-dark border px-3 py-2"
                        style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $product->jenis_kayu }}
                    </span>
                </div>

                {{-- Nama Produk --}}
                <h1 class="fw-bold mb-3" style="font-size: 28px; color: #212529; line-height: 1.3;">
                    {{ $product->nama_produk }}
                </h1>

                {{-- Rating & Reviews --}}
                @if ($product->reviews->count() > 0)
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center me-3">
                            <span class="fw-bold me-2" style="font-size: 18px; color: #212529;">
                                {{ number_format($product->reviews->avg('rating'), 1) }}
                            </span>
                            @php
                                $avg = round($product->reviews->avg('rating'));
                            @endphp
                            <div>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $avg)
                                        <span style="color: #ffc107; font-size: 16px;">★</span>
                                    @else
                                        <span style="color: #e0e0e0; font-size: 16px;">★</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <span class="text-muted" style="font-size: 14px;">
                            ({{ $product->reviews->count() }} ulasan)
                        </span>
                    </div>
                @else
                    <div class="mb-3">
                        <span class="text-muted" style="font-size: 14px;">
                            ⭐ Belum ada rating
                        </span>
                    </div>
                @endif

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <p class="text-muted" style="font-size: 15px; line-height: 1.7;">
                        {{ $product->deskripsi ?? 'Tidak ada deskripsi produk.' }}
                    </p>
                </div>

                <hr class="my-4">

                {{-- VARIAN PRODUK --}}
                <div class="mb-4">
                    <h5 class="fw-bold mb-3" style="font-size: 18px; color: #212529;">Pilih Varian Produk</h5>

                    @if ($product->variants->isEmpty())
                        <div class="alert alert-light border" role="alert" style="font-size: 14px;">
                            Belum ada varian tersedia untuk produk ini.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle" style="font-size: 14px;">
                                <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                                    <tr>
                                        <th class="fw-semibold" style="padding: 12px;">Ukuran</th>
                                        <th class="fw-semibold text-center" style="padding: 12px;">Stok</th>
                                        <th class="fw-semibold text-end" style="padding: 12px;">Harga</th>
                                        {{-- <th class="fw-semibold text-end" style="padding: 12px;">Harga/m³</th> --}}
                                        <th class="fw-semibold text-center" style="padding: 12px; width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->variants as $variant)
                                        <tr style="border-bottom: 1px solid #f0f0f0;">
                                            <td style="padding: 14px;">
                                                <span class="fw-semibold">{{ $variant->ukuran }}</span>
                                            </td>
                                            <td class="text-center" style="padding: 14px;">
                                                @if ($variant->stok > 0)
                                                    <span class="badge bg-success-subtle text-success"
                                                        style="font-size: 12px; font-weight: 500; padding: 4px 10px;">
                                                        {{ $variant->stok }} pcs
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger"
                                                        style="font-size: 12px; font-weight: 500; padding: 4px 10px;">
                                                        Habis
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-end" style="padding: 14px;">
                                                <span class="fw-semibold">Rp
                                                    {{ number_format($variant->harga, 0, ',', '.') }}</span>
                                            </td>
                                            {{-- <td class="text-end" style="padding: 14px;">
                                                <span class="text-muted">Rp {{ number_format($variant->harga_m3, 0, ',', '.') }}</span>
                                            </td> --}}
                                            <td class="text-center" style="padding: 14px;">
                                                <form action="{{ route('cart.add', $variant->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm rounded-2 d-inline-flex align-items-center justify-content-center"
                                                        style="padding: 8px 16px; font-size: 13px; font-weight: 500;"
                                                        {{ $variant->stok <= 0 ? 'disabled' : '' }}>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" fill="currentColor" class="me-1"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                                                            <path
                                                                d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                        </svg>
                                                        Tambah
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>
        </div>


        {{-- ==== DAFTAR ULASAN / TESTIMONI ==== --}}
        <div class="mt-5 pt-4" style="border-top: 1px solid #e0e0e0;">
            <h4 class="fw-bold mb-4" style="font-size: 22px; color: #212529;">
                Ulasan Pembeli
                @if ($product->reviews->count() > 0)
                    <span class="text-muted" style="font-size: 16px; font-weight: 400;">
                        ({{ $product->reviews->count() }})
                    </span>
                @endif
            </h4>

            @if ($product->reviews->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3" style="font-size: 48px; opacity: 0.3;">📝</div>
                    <p class="text-muted" style="font-size: 15px;">Belum ada ulasan untuk produk ini.</p>
                    <p class="text-muted" style="font-size: 13px;">Jadilah yang pertama memberikan ulasan!</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach ($product->reviews as $review)
                        <div class="col-12">
                            <div class="card border-0 rounded-3" style="background-color: #f8f9fa; padding: 20px;">

                                {{-- Header: Nama & Rating --}}
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">
                                        {{-- Avatar --}}
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px; font-size: 16px; font-weight: 600;">
                                            {{ strtoupper(substr($review->name, 0, 1)) }}
                                        </div>

                                        {{-- Nama --}}
                                        <div>
                                            <h6 class="fw-bold mb-0" style="font-size: 15px; color: #212529;">
                                                {{ $review->name }}
                                            </h6>
                                            <small class="text-muted" style="font-size: 12px;">
                                                {{ $review->created_at ? $review->created_at->format('d M Y') : '' }}
                                            </small>
                                        </div>
                                    </div>

                                    {{-- Rating Stars --}}
                                    <div>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <span style="color: #ffc107; font-size: 16px;">★</span>
                                            @else
                                                <span style="color: #e0e0e0; font-size: 16px;">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                {{-- Content --}}
                                <p class="mb-0 mt-2" style="font-size: 14px; color: #495057; line-height: 1.6;">
                                    {{ $review->content }}
                                </p>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <p style="margin-bottom: 10px; font-size: 15px;">{{ session('success') }}</p>
                        <hr style="margin: 15px 0;">
                        <table style="width: 100%; font-size: 14px;">
                            <tr>
                                <td style="padding: 5px 0;"><strong>Produk:</strong></td>
                                <td style="padding: 5px 0;">{{ session('product_name') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0;"><strong>Ukuran:</strong></td>
                                <td style="padding: 5px 0;">{{ session('variant_size') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0;"><strong>Harga:</strong></td>
                                <td style="padding: 5px 0;">Rp {{ session('variant_price') }}</td>
                            </tr>
                        </table>
                    </div>
                `,
                confirmButtonColor: '#198754',
                confirmButtonText: 'OK'
            })
        </script>
    @endif
@endsection
