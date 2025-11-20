
@extends('layouts.app')
@section('title', 'Katalog Produk Kayu')
@section('content')

<div class="d-flex">

    <!-- =======================
         SIDEBAR
    ======================= -->
  @include('shop.sidebar')

    <!-- ===========================
         KONTEN YANG SUDAH ADA
         (TIDAK DIUBAH)
    ============================ -->
    <div class="flex-grow-1">

       <div class="container py-5">
    <h2 class="mb-4 fw-bold text-primary text-center">Katalog Produk Kayu</h2>

    <!-- Form Pencarian & Filter -->
    <form method="GET" action="{{ route('shop.index') }}" class="mb-4">
        <div class="card border-0 rounded-3 mb-4" style="background-color: #f8f9fa;">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">

                    <!-- Input Search -->
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-dark mb-2" style="font-size: 14px;">Cari Produk</label>
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control border-1 rounded-2" 
                            placeholder="Cari nama produk..." 
                            value="{{ request('search') }}"
                            style="padding: 10px 15px; border-color: #dee2e6;">
                    </div>

                    <!-- Dropdown Jenis Kayu -->
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-dark mb-2" style="font-size: 14px;">Jenis Kayu</label>
                        <select name="jenis_kayu" 
                                class="form-select border-1 rounded-2"
                                style="padding: 10px 15px; border-color: #dee2e6;">
                            <option value="">Semua Jenis Kayu</option>
                            @foreach($jenisKayuList as $jenis)
                                <option value="{{ $jenis }}"
                                    {{ request('jenis_kayu') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Filter -->
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary rounded-2" type="submit" style="padding: 10px 20px; font-weight: 500;">
                            Filter
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- Grid Produk -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card border-0 rounded-3 position-relative h-100" style="overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s;">
                    
                    <!-- Badge Jenis Kayu -->
                    <div class="position-absolute top-0 start-0 m-2" style="z-index: 10;">
                        <span class="badge bg-success rounded-pill px-3 py-2" style="font-size: 11px; font-weight: 600;">
                            {{ $product->jenis_kayu }}
                        </span>
                    </div>

                    <!-- Gambar Produk -->
                    <div style="background-color: #f8f9fa; height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($product->gambar)
                            <img src="{{ asset('uploads/products/'.$product->gambar) }}" 
                                 alt="{{ $product->nama_produk }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image" 
                                 alt="No Image"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>

                    <div class="card-body p-3 d-flex flex-column">
                        
                        <!-- Nama Produk -->
                        <h6 class="fw-bold mb-2" style="font-size: 14px; color: #212529; line-height: 1.4; min-height: 40px;">
                            {{ $product->nama_produk }}
                        </h6>

                        <!-- Rating & Reviews -->
                        @if ($product->reviews && $product->reviews->count() > 0)
                            <div class="mb-2 d-flex align-items-center">
                                @php
                                    $avgRating = $product->reviews->avg('rating');
                                    $roundedRating = round($avgRating);
                                    $reviewCount = $product->reviews->count();
                                @endphp
                                
                                <!-- Bintang Rating -->
                                <div class="me-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $roundedRating)
                                            <span style="color: #ffc107; font-size: 14px;">★</span>
                                        @else
                                            <span style="color: #e0e0e0; font-size: 14px;">★</span>
                                        @endif
                                    @endfor
                                </div>
                                
                                <!-- Angka Rating & Jumlah Review -->
                                <span class="text-muted" style="font-size: 12px;">
                                    {{ number_format($avgRating, 1) }} ({{ $reviewCount }})
                                </span>
                            </div>
                        @else
                            <div class="mb-2">
                                <span style="color: #e0e0e0; font-size: 14px;">★★★★★</span>
                                <span class="text-muted ms-1" style="font-size: 12px;">(0)</span>
                            </div>
                        @endif

                        <!-- Harga Range (opsional) -->
                        @if($product->variants && $product->variants->count() > 0)
                            @php
                                $minPrice = $product->variants->min('harga');
                                $maxPrice = $product->variants->max('harga');
                            @endphp
                            <p class="text-muted mb-2" style="font-size: 12px;">
                                @if($minPrice == $maxPrice)
                                    Rp {{ number_format($minPrice, 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($minPrice, 0, ',', '.') }} - {{ number_format($maxPrice, 0, ',', '.') }}
                                @endif
                            </p>
                        @endif

                        <!-- Spacer untuk push button ke bawah -->
                        <div class="mt-auto pt-2">
                            <a href="{{ route('shop.show', $product->id) }}" 
                               class="btn btn-outline-primary w-100 rounded-2" 
                               style="padding: 8px 16px; font-size: 13px; font-weight: 500; border-width: 1.5px;">
                                Lihat Detail
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-3" style="font-size: 64px; opacity: 0.2;">🔍</div>
                    <h5 class="text-muted mb-2">Produk Tidak Ditemukan</h5>
                    <p class="text-muted" style="font-size: 14px;">
                        Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination (jika ada) -->
    @if(method_exists($products, 'links'))
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    @endif

</div>

<style>
    /* Hover Effect untuk Card */
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.12) !important;
    }

    /* Smooth transition */
    .card {
        transition: all 0.3s ease;
    }

    /* Button hover effect */
    .btn-outline-primary:hover {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }
</style>

    </div>

</div>

@endsection






