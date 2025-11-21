@extends('admin.layouts.base')

@section('title', 'Edit Produk')

@section('content')
<div class="container mt-5 pb-5">
    <div class="card shadow-sm mx-auto" style="max-width: 900px;">
        <div class="card-header bg-brown text-white text-center py-3">
            <h5>Edit Produk Kayu</h5>
        </div>

        <div class="card-body px-4 py-4">
            @if($errors->any())
                <div class="alert alert-danger rounded-3">
                    <strong>Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- DATA PRODUK UTAMA --}}
                <h5 class="text-brown mb-3 fw-bold">Informasi Produk</h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control form-control-lg"
                               value="{{ old('nama_produk', $product->nama_produk) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kayu</label>
                        <select name="jenis_kayu" class="form-select form-select-lg" required>
                            <option value="" disabled>Pilih Jenis Kayu</option>
                            @foreach ($jenisKayuList as $kayu)
                                <option value="{{ $kayu }}" {{ old('jenis_kayu', $product->jenis_kayu) == $kayu ? 'selected' : '' }}>
                                    {{ $kayu }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Produk</label><br>
                    @if($product->gambar)
                        <img src="{{ asset('uploads/products/'.$product->gambar) }}" alt="Gambar Produk" class="img-thumbnail mb-2" width="150">
                    @endif
                    <input type="file" name="gambar" class="form-control form-control-lg" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control form-control-lg">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                </div>

                {{-- VARIAN PRODUK --}}
                <hr>
                <h5 class="text-brown text-center mb-4 fw-bold">Varian Produk</h5>

                <div id="variant-wrapper">
                    @foreach($product->variants as $index => $variant)
                        <div class="variant-item border rounded-3 p-3 mb-3 bg-light">
                            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Ukuran</label>
                                    <input type="text" name="variants[{{ $index }}][ukuran]" class="form-control"
                                           value="{{ $variant->ukuran }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="variants[{{ $index }}][stok]" class="form-control"
                                           value="{{ $variant->stok }}" min="0" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Harga</label>
                                    <input type="number" name="variants[{{ $index }}][harga]" class="form-control"
                                           value="{{ $variant->harga }}" min="0" required>
                                </div>
                                {{-- <div class="col-md-2">
                                    <label class="form-label">Harga/m³ (Rp)</label>
                                    <input type="number" name="variants[{{ $index }}][harga_m3]" class="form-control"
                                           value="{{ $variant->harga_m3 ?? 0 }}" min="0" required>
                                </div> --}}
                                <div class="col-md-3 d-flex align-items-end justify-content-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-variant">Hapus</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-end mb-4">
                    <button type="button" class="btn btn-success btn-sm px-4" id="add-variant">+ Tambah Varian</button>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-brown w-100 py-2 rounded-3 fw-bold">
                        💾 Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- STYLE --}}
<style>
    .bg-brown { background-color: #7b4f2b !important; }
    .text-brown { color: #7b4f2b !important; }
    .btn-brown { background-color: #7b4f2b; color:#fff; border-radius:10px; }
    .btn-brown:hover { background-color:#5c3b1e; color:#fff; }
</style>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let variantIndex = @json($product->variants->count());
        const wrapper = document.getElementById('variant-wrapper');

        document.getElementById('add-variant').addEventListener('click', function () {
            const v = document.createElement('div');
            v.classList.add('variant-item', 'border', 'rounded-3', 'p-3', 'mb-3', 'bg-light');

            v.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Ukuran</label>
                        <input type="text" name="variants[${variantIndex}][ukuran]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Stok</label>
                        <input type="number" name="variants[${variantIndex}][stok]" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Harga Satuan (Rp)</label>
                        <input type="number" name="variants[${variantIndex}][harga]" class="form-control" min="0" required>
                    </div>
                   
                    <div class="col-md-3 d-flex align-items-end justify-content-end">
                        <button type="button" class="btn btn-danger btn-sm remove-variant">Hapus</button>
                    </div>
                </div>
            `;
            wrapper.appendChild(v);
            variantIndex++;
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-variant')) {
                e.target.closest('.variant-item').remove();
            }
        });
    });
</script>

@endsection
