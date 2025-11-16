@extends('layouts.app')

@section('title', 'Daftar Jasa')

@section('content')
<div class="container py-5">

    <h2 class="mb-4 fw-bold text-primary text-center">Daftar Jasa Kami</h2>

    {{-- FILTER KATEGORI --}}
    <form method="GET" class="mb-4">
        <div class="card border-0 rounded-3 mb-4" style="background-color: #f8f9fa;">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">

                    {{-- Search --}}
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-dark mb-2" style="font-size: 14px;">Cari Layanan</label>
                        <input type="text" 
                               name="search" 
                               class="form-control border-1 rounded-2"
                               placeholder="Cari nama layanan..."
                               value="{{ request('search') }}"
                               style="padding: 10px 15px; border-color: #dee2e6;">
                    </div>

                    {{-- Category Filter --}}
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-dark mb-2" style="font-size: 14px;">Kategori</label>
                        <select name="category" 
                                class="form-select border-1 rounded-2"
                                style="padding: 10px 15px; border-color: #dee2e6;">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" 
                                    {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Button --}}
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary rounded-2" style="padding: 10px 20px; font-weight: 500;">
                            Filter
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    @php $selected = request('category'); @endphp

    {{-- JIKA ADA FILTER, TAMPILKAN SATU KATEGORI --}}
    @if($selected)
        @php $category = $categories->firstWhere('id', $selected); @endphp

        <h4 class="fw-bold text-dark mb-4" style="font-size: 20px;">{{ $category->name }}</h4>

        <div class="row g-4 mb-5">
            @foreach($category->items as $item)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 rounded-3 position-relative" style="overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s;">
                        
                        {{-- Badge (opsional - bisa disesuaikan) --}}
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
                                {{ $category->name }}
                            </p>

                            {{-- Nama Item --}}
                            <h6 class="fw-bold mb-2" style="font-size: 14px; color: #212529; line-height: 1.4;">
                                {{ $item->name }}
                            </h6>

                            {{-- Rating (opsional - bisa disesuaikan) --}}
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
            @endforeach
        </div>

    {{-- TANPA FILTER → TAMPILKAN SEMUA KATEGORI --}}
    @else
        @foreach($categories as $category)
            <h4 class="fw-bold text-dark mb-4" style="font-size: 20px;">{{ $category->name }}</h4>

            <div class="row g-4 mb-5">
                @foreach($category->items as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card border-0 rounded-3 position-relative" style="overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s;">
                            
                            {{-- Badge (opsional - bisa disesuaikan) --}}
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
                                    {{ $category->name }}
                                </p>

                                {{-- Nama Item --}}
                                <h6 class="fw-bold mb-2" style="font-size: 14px; color: #212529; line-height: 1.4;">
                                    {{ $item->name }}
                                </h6>

                                {{-- Rating (opsional - bisa disesuaikan) --}}
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
                @endforeach
            </div>
        @endforeach
    @endif

</div>

<style>
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;
    }
</style>
@endsection