@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container py-5">

    <h2 class="mb-5 text-center fw-bold text-primary">Pesanan Saya</h2>

    {{-- ================== Produk Biasa ================== --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold text-dark mb-0" style="font-size: 20px;">Pesanan Produk</h4>
        <span class="badge bg-primary-subtle text-primary px-3 py-2" style="font-size: 13px;">
            {{ $orders->count() }} Pesanan
        </span>
    </div>

    @if ($orders->isEmpty())
        <div class="text-center py-5 mb-5" style="background-color: #f8f9fa; border-radius: 12px;">
            <div class="mb-3" style="font-size: 64px; opacity: 0.3;">📦</div>
            <h5 class="text-muted mb-2">Belum Ada Pesanan Produk</h5>
            <p class="text-muted" style="font-size: 14px;">Mulai belanja produk kayu berkualitas sekarang!</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3 rounded-2">
                Belanja Sekarang
            </a>
        </div>
    @else
        <div class="row g-4 mb-5">
            @foreach ($orders as $order)
                <div class="col-12">
                    <div class="card border-0 rounded-3" style="box-shadow: 0 2px 12px rgba(0,0,0,0.08); overflow: hidden;">
                        
                        {{-- Header Card --}}
                        <div class="card-header border-0 d-flex justify-content-between align-items-center" 
                             style="background: linear-gradient(135deg, #198754 0%, #20c997 100%); padding: 16px 24px;">
                            <div class="text-white">
                                <h6 class="mb-1 fw-bold" style="font-size: 16px;">
                                    <i class="bi bi-bag-check-fill me-2"></i>Order #{{ $order->id }}
                                </h6>
                                <small style="opacity: 0.9; font-size: 13px;">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-white text-success px-3 py-2" style="font-size: 12px; font-weight: 600;">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 24px;">
                            
                            {{-- Info Pelanggan --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-3"
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="bi bi-person-fill text-success" style="font-size: 18px;"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 12px;">Nama Pelanggan</small>
                                            <strong style="font-size: 14px;">{{ $order->nama_pelanggan }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-3"
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="bi bi-geo-alt-fill text-success" style="font-size: 18px;"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 12px;">Alamat Pengiriman</small>
                                            <strong style="font-size: 14px;">{{ $order->alamat }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded-2" style="background-color: #fff3cd;">
                                        <i class="bi bi-credit-card text-warning me-3" style="font-size: 24px;"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 12px;">Status Pembayaran</small>
                                            <strong style="font-size: 14px;">{{ ucfirst($order->payment_status) }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded-2" 
                                         style="background-color: {{ $order->status == 'selesai' ? '#d1e7dd' : '#cfe2ff' }};">
                                        <i class="bi bi-truck me-3" 
                                           style="font-size: 24px; color: {{ $order->status == 'selesai' ? '#198754' : '#0d6efd' }};">
                                        </i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 12px;">Status Pesanan</small>
                                            <strong style="font-size: 14px;">{{ ucfirst($order->status) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="margin: 20px 0; border-top: 1px dashed #dee2e6;">

                            {{-- Item Pesanan --}}
                            <div class="mb-3">
                                <h6 class="fw-semibold mb-3" style="color: #198754; font-size: 15px;">
                                    <i class="bi bi-list-ul me-2"></i>Item Pesanan
                                </h6>
                                @if ($order->Items && $order->Items->count())
                                    <div class="d-flex flex-column gap-2">
                                        @foreach ($order->Items as $item)
                                            <div class="d-flex justify-content-between align-items-center p-3 rounded-2" 
                                                 style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                                <div class="d-flex align-items-center flex-grow-1">
                                                    <div class="me-3">
                                                        @if($item->product && $item->product->gambar)
                                                            <img src="{{ asset('uploads/products/' . $item->product->gambar) }}" 
                                                                 alt="{{ $item->product->nama_produk }}"
                                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                                        @else
                                                            <div style="width: 50px; height: 50px; background-color: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                                                <i class="bi bi-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <strong style="font-size: 14px; display: block;">
                                                            {{ $item->product->nama_produk ?? '-' }}
                                                        </strong>
                                                        <small class="text-muted">Qty: {{ $item->qty }}</small>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <strong class="text-success" style="font-size: 15px;">
                                                        Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                                                    </strong>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0" style="font-size: 14px;">Tidak ada item pada order ini.</p>
                                @endif
                            </div>

                            {{-- Total --}}
                            <div class="d-flex justify-content-between align-items-center p-3 rounded-2" 
                                 style="background-color: #d1e7dd; border: 2px solid #198754;">
                                <span class="fw-semibold" style="font-size: 16px; color: #198754;">
                                    Total Pembayaran
                                </span>
                                <span class="fw-bold" style="font-size: 20px; color: #198754;">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="row g-2 mt-3">
                                <div class="col-md-6">
                                    <a href="{{ route('checkout.success', $order->id) }}" 
                                       class="btn btn-outline-primary w-100 rounded-2" 
                                       style="padding: 10px; font-weight: 500; font-size: 14px;">
                                        <i class="bi bi-eye me-2"></i>Lihat Detail
                                    </a>
                                </div>
                                @if($order->status == 'selesai')
                                    <div class="col-md-6">
                                        <button type="button" 
                                                class="btn btn-warning w-100 rounded-2" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#reviewModal{{ $order->id }}"
                                                style="padding: 10px; font-weight: 500; font-size: 14px; color: #000;">
                                            <i class="bi bi-star-fill me-2"></i>Beri Ulasan
                                        </button>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Modal Review untuk setiap order --}}
                @if($order->status == 'selesai')
                <div class="modal fade" id="reviewModal{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 rounded-3" style="box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                            <div class="modal-header border-0" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%); padding: 20px 24px;">
                                <h5 class="modal-title text-white fw-bold">
                                    <i class="bi bi-star-fill me-2"></i>Beri Rating & Testimoni
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('review.store', $order->id) }}" method="POST">
                                @csrf
                                <div class="modal-body" style="padding: 24px;">
                                    
                                    {{-- Nama User --}}
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold mb-2" style="font-size: 14px;">
                                            Nama Anda
                                        </label>
                                        <input type="text" 
                                               name="name" 
                                               class="form-control rounded-2" 
                                               placeholder="Masukkan nama Anda" 
                                               required
                                               value="{{ $order->nama_pelanggan }}"
                                               style="padding: 10px;">
                                    </div>

                                    <hr style="margin: 20px 0; border-top: 1px dashed #dee2e6;">

                                    <h6 class="fw-bold mb-3" style="color: #198754;">
                                        <i class="bi bi-list-check me-2"></i>Rating untuk Produk
                                    </h6>

                                    @php
                                        // Ambil produk unik hanya berdasarkan product_id
                                        $uniqueItems = $order->Items->unique('product_id');
                                    @endphp

                                    {{-- Loop setiap produk unik --}}
                                    @foreach($uniqueItems as $item)
                                        <div class="card border-0 mb-3" style="background-color: #f8f9fa; padding: 16px; border-radius: 8px;">
                                            
                                            {{-- Nama Produk --}}
                                            <div class="d-flex align-items-center mb-3">
                                                @if($item->product && $item->product->gambar)
                                                    <img src="{{ asset('uploads/products/' . $item->product->gambar) }}" 
                                                         alt="{{ $item->product->nama_produk }}"
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; margin-right: 12px;">
                                                @endif
                                                <strong style="font-size: 15px; color: #212529;">
                                                    {{ $item->product->nama_produk ?? '-' }}
                                                </strong>
                                            </div>

                                            {{-- Rating Bintang --}}
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold mb-2" style="font-size: 13px;">
                                                    Rating (1-5 Bintang)
                                                </label>
                                                <div class="d-flex gap-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <label class="rating-star-{{ $order->id }}-{{ $item->product_id }}" 
                                                               style="cursor: pointer; font-size: 28px;">
                                                            <input type="radio" 
                                                                   name="rating[{{ $item->product_id }}]" 
                                                                   value="{{ $i }}" 
                                                                   required 
                                                                   style="display: none;">
                                                            <span class="star" style="color: #e0e0e0; transition: color 0.2s;">★</span>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>

                                            {{-- Testimoni --}}
                                            <div>
                                                <label class="form-label fw-semibold mb-2" style="font-size: 13px;">
                                                    Testimoni / Ulasan
                                                </label>
                                                <textarea name="content[{{ $item->product_id }}]" 
                                                          class="form-control rounded-2" 
                                                          rows="3" 
                                                          placeholder="Ceritakan pengalaman Anda dengan produk ini..." 
                                                          required
                                                          style="padding: 10px; resize: none; font-size: 14px;"></textarea>
                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                                <div class="modal-footer border-0" style="padding: 16px 24px;">
                                    <button type="button" class="btn btn-light rounded-2" data-bs-dismiss="modal" style="padding: 10px 20px;">
                                        Tutup
                                    </button>
                                    <button type="submit" class="btn btn-success rounded-2" style="padding: 10px 20px; font-weight: 500;">
                                        <i class="bi bi-send-fill me-2"></i>Kirim Semua Rating
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @endif

    {{-- ================== Service Order ================== --}}
    <div class="d-flex align-items-center justify-content-between mb-4 mt-5">
        <h4 class="fw-bold text-dark mb-0" style="font-size: 20px;">Pesanan Layanan</h4>
        <span class="badge bg-primary-subtle text-primary px-3 py-2" style="font-size: 13px;">
            {{ $serviceOrders->count() }} Pesanan
        </span>
    </div>

    @if ($serviceOrders->isEmpty())
        <div class="text-center py-5" style="background-color: #f8f9fa; border-radius: 12px;">
            <div class="mb-3" style="font-size: 64px; opacity: 0.3;">🛠️</div>
            <h5 class="text-muted mb-2">Belum Ada Pesanan Layanan</h5>
            <p class="text-muted" style="font-size: 14px;">Pesan layanan jasa terbaik untuk kebutuhan Anda!</p>
            <a href="{{ route('shop.services.index') }}" class="btn btn-primary mt-3 rounded-2">
                Lihat Layanan
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($serviceOrders as $order)
                <div class="col-12">
                    <div class="card border-0 rounded-3" style="box-shadow: 0 2px 12px rgba(0,0,0,0.08); overflow: hidden;">
                        
                        {{-- Header Card --}}
                        <div class="card-header border-0 d-flex justify-content-between align-items-center" 
                             style="background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%); padding: 16px 24px;">
                            <div class="text-white">
                                <h6 class="mb-1 fw-bold" style="font-size: 16px;">
                                    <i class="bi bi-tools me-2"></i>Service #{{ $order->id }}
                                </h6>
                                <small style="opacity: 0.9; font-size: 13px;">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-white text-primary px-3 py-2" style="font-size: 12px; font-weight: 600;">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 24px;">
                            
                            {{-- Info Pelanggan --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="bi bi-person-fill text-primary" style="font-size: 18px;"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 12px;">Nama Pelanggan</small>
                                            <strong style="font-size: 14px;">{{ $order->customer_name }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="bi bi-geo-alt-fill text-primary" style="font-size: 18px;"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 12px;">Alamat</small>
                                            <strong style="font-size: 14px;">{{ $order->address }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded-2" style="background-color: #fff3cd;">
                                        <i class="bi bi-credit-card text-warning me-3" style="font-size: 24px;"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 12px;">Status Pembayaran</small>
                                            <strong style="font-size: 14px;">{{ ucfirst($order->payment_status) }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded-2" 
                                         style="background-color: {{ $order->order_status == 'completed' ? '#d1e7dd' : '#cfe2ff' }};">
                                        <i class="bi bi-tools me-3" 
                                           style="font-size: 24px; color: {{ $order->order_status == 'completed' ? '#198754' : '#0d6efd' }};">
                                        </i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 12px;">Status Layanan</small>
                                            <strong style="font-size: 14px;">{{ ucfirst($order->order_status) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="margin: 20px 0; border-top: 1px dashed #dee2e6;">

                            {{-- Layanan --}}
                            <div class="mb-3">
                                <h6 class="fw-semibold mb-3" style="color: #0d6efd; font-size: 15px;">
                                    <i class="bi bi-wrench me-2"></i>Detail Layanan
                                </h6>
                                <div class="p-3 rounded-2" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                    <strong style="font-size: 14px; display: block;">
                                        {{ $order->item->name ?? '-' }}
                                    </strong>
                                    <small class="text-muted">
                                        {{ number_format($order->total_price / ($order->item->price ?? 1), 2) }} {{ $order->item->unit ?? '' }}
                                    </small>
                                </div>
                            </div>

                            {{-- Bukti Pembayaran --}}
                            @if($order->payment_proof)
                            <div class="mb-3">
                                <h6 class="fw-semibold mb-2" style="color: #0d6efd; font-size: 15px;">
                                    <i class="bi bi-receipt me-2"></i>Bukti Pembayaran
                                </h6>
                                <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                                     alt="Bukti Pembayaran" 
                                     class="img-thumbnail rounded-2" 
                                     style="max-width: 150px; border: 2px solid #0d6efd; cursor: pointer;"
                                     onclick="window.open(this.src, '_blank')">
                            </div>
                            @endif

                            {{-- Total --}}
                            <div class="d-flex justify-content-between align-items-center p-3 rounded-2" 
                                 style="background-color: #cfe2ff; border: 2px solid #0d6efd;">
                                <span class="fw-semibold" style="font-size: 16px; color: #0d6efd;">
                                    Total Pembayaran
                                </span>
                                <span class="fw-bold" style="font-size: 20px; color: #0d6efd;">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

<style>
    /* Hover Effects */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12) !important;
    }

    /* Rating Star Interactive */
    .rating-star input:checked ~ .star,
    .rating-star:hover .star,
    .rating-star:hover ~ .rating-star .star {
        color: #ffc107 !important;
    }

    .rating-star .star:hover {
        color: #ffc107 !important;
    }

    /* Button Hover */
    .btn-outline-primary:hover {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }

    .btn-warning:hover {
        background-color: #ffc107;
        border-color: #ffc107;
    }
</style>

<script>
    // Interactive Rating Stars for Multiple Products
    document.addEventListener('DOMContentLoaded', function() {
        // Get all modals
        document.querySelectorAll('[id^="reviewModal"]').forEach(modal => {
            // Find all rating groups within this modal
            const ratingGroups = new Map();
            
            modal.querySelectorAll('[class*="rating-star-"]').forEach(label => {
                // Extract group identifier from class
                const classes = label.className.split(' ');
                const groupClass = classes.find(c => c.startsWith('rating-star-'));
                
                if (!ratingGroups.has(groupClass)) {
                    ratingGroups.set(groupClass, []);
                }
                ratingGroups.get(groupClass).push(label);
            });
            
            // Set up interaction for each group
            ratingGroups.forEach((stars, groupClass) => {
                stars.forEach((label, index) => {
                    label.addEventListener('click', function() {
                        // Uncheck all in this group
                        stars.forEach(s => {
                            s.querySelector('.star').style.color = '#e0e0e0';
                            s.querySelector('input').checked = false;
                        });
                        
                        // Check selected and previous stars
                        for(let i = 0; i <= index; i++) {
                            stars[i].querySelector('.star').style.color = '#ffc107';
                        }
                        
                        // Check the radio
                        this.querySelector('input').checked = true;
                    });
                    
                    // Hover effect
                    label.addEventListener('mouseenter', function() {
                        for(let i = 0; i <= index; i++) {
                            stars[i].querySelector('.star').style.color = '#ffc107';
                        }
                    });
                    
                    label.addEventListener('mouseleave', function() {
                        stars.forEach((s, i) => {
                            const input = s.querySelector('input');
                            if(!input.checked) {
                                s.querySelector('.star').style.color = '#e0e0e0';
                            } else {
                                // Keep checked stars gold
                                const checkedIndex = stars.findIndex(st => st.querySelector('input').checked);
                                if(i <= checkedIndex) {
                                    s.querySelector('.star').style.color = '#ffc107';
                                }
                            }
                        });
                    });
                });
            });
        });
    });
</script>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        confirmButtonColor: '#198754',
        confirmButtonText: 'OK'
    });
</script>
@endif
@endsection