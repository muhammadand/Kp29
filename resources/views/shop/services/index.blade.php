@extends('layouts.app')
@section('title', 'Katalog Produk Kayu')
@section('content')

<div class="d-flex">

    <!-- =======================
         SIDEBAR
    ======================= -->
    @include('shop.sidebar')
   
    <!-- ===========================
         KONTEN UTAMA
    ============================ -->
    <div class="flex-grow-1">

        <div class="container py-5">

    <h2 class="mb-4 fw-bold text-primary text-center">
        Kategori Layanan
    </h2>

    <div class="row g-4">
        @forelse ($categories as $cat)
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="card border-0 rounded-3 shadow-sm h-100" 
                     style="overflow: hidden; transition: 0.3s;">
                     
                    {{-- Gambar Category --}}
                    <div style="height: 180px; background: #f8f9fa; overflow: hidden;">
                        @if($cat->image)
                            <img src="{{ asset('storage/'.$cat->image) }}" 
                                 alt="{{ $cat->name }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">

                        {{-- Nama kategori --}}
                        <h5 class="fw-bold mb-2" style="font-size: 16px;">
                            {{ $cat->name }}
                        </h5>

                        {{-- Deskripsi singkat --}}
                        <p class="text-muted" style="font-size: 13px; min-height: 60px;">
                            {{ Str::limit($cat->description, 90) }}
                        </p>

                        <div class="mt-auto">
                            <button type="button" 
                                    class="btn btn-outline-primary w-100 rounded-2"
                                    style="font-size: 14px; font-weight: 500;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalCategory{{ $cat->id }}">
                                Lihat Layanan
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 text-muted">
                    <h5>Tidak ada kategori ditemukan</h5>
                </div>
            </div>
        @endforelse
    </div>

</div>


<!-- ===========================
     MODAL UNTUK SETIAP KATEGORI
============================ -->
@foreach($categories as $cat)
<div class="modal fade" id="modalCategory{{ $cat->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $cat->id }}" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      
      <div class="modal-header border-0 bg-success">
        <h5 class="modal-title text-white fw-bold" id="modalLabel{{ $cat->id }}">
          <i class="bi bi-grid-3x3-gap-fill me-2"></i>{{ $cat->name }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">

        {{-- FILTER & PENCARIAN DI DALAM MODAL --}}
        <form method="GET" action="{{ route('shop.services') }}" class="mb-4">
            <input type="hidden" name="category" value="{{ $cat->id }}">
            
            <div class="card border-0 rounded-3 mb-4" style="background-color: #f8f9fa;">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-end">

                        {{-- Search --}}
                        <div class="col-md-10">
                            <label class="form-label fw-semibold text-dark mb-2" style="font-size: 14px;">
                                <i class="bi bi-search me-1"></i>Cari Layanan
                            </label>
                            <input type="text" 
                                   name="search" 
                                   class="form-control border-1 rounded-2"
                                   placeholder="Cari nama layanan dalam kategori ini..."
                                   value="{{ request('search') }}"
                                   style="padding: 10px 15px; border-color: #dee2e6;">
                        </div>

                        {{-- Button --}}
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-primary rounded-2" style="padding: 10px 20px; font-weight: 500;">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>

        {{-- DAFTAR LAYANAN --}}
        <div class="row g-4">
            @forelse($cat->items as $item)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 rounded-3 position-relative" 
                         style="overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s;">
                        
                        {{-- Badge --}}
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-success rounded-pill px-3 py-2" style="font-size: 11px; font-weight: 600;">
                                Popular
                            </span>
                        </div>

                        {{-- Gambar --}}
                        <div style="background-color: #f8f9fa; height: 200px; display: flex; align-items: center; justify-content: center;">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" 
                                     alt="{{ $item->name }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="text-muted">No Image</div>
                            @endif
                        </div>

                        <div class="card-body p-3">
                            {{-- Kategori kecil --}}
                            <p class="text-muted mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                {{ $cat->name }}
                            </p>

                            {{-- Nama Item --}}
                            <h6 class="fw-bold mb-2" style="font-size: 14px; color: #212529; line-height: 1.4;">
                                {{ $item->name }}
                            </h6>

                            {{-- Rating --}}
                            <div class="mb-2">
                                <span class="text-warning" style="font-size: 12px;">★★★★★</span>
                                <span class="text-muted ms-1" style="font-size: 11px;">0</span>
                            </div>

                            {{-- Satuan --}}
                            <p class="text-muted mb-2" style="font-size: 12px;">
                                Per {{ $item->unit }}
                            </p>

                            {{-- Price & Button --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold text-dark" style="font-size: 16px;">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <a href="{{ route('shop.services.show', $item->id) }}"
                                   class="btn btn-success btn-sm rounded-2 d-flex align-items-center justify-content-center"
                                   style="width: 36px; height: 36px; padding: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada layanan dalam kategori ini.
                    </div>
                </div>
            @endforelse
        </div>

      </div>
      
      <div class="modal-footer border-0 bg-light">
        <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i>Tutup
        </button>
      </div>
      
    </div>
  </div>
</div>
@endforeach


<!-- ===========================
     BAGIAN BAWAH (TETAP ADA)
============================ -->


<style>
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;
    }
    
    /* Styling untuk modal scrollable */
    .modal-body::-webkit-scrollbar {
        width: 8px;
    }
    
    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .modal-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

</div>

@endsection