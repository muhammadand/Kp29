@extends('admin.layouts.base')

@section('title', 'Tambah Produk')

@section('content')
<div class="container mt-5 pb-5">

    <div class="card shadow rounded-4 mx-auto" style="max-width: 900px; border: none;">
        <div class="card-header bg-brown text-white text-center py-3 rounded-top-4">
            <h5 class="mb-0">Tambah Produk Kayu</h5>
        </div>

        <div class="card-body px-4 py-4">

            {{-- Error Alert --}}
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

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- DATA PRODUK UTAMA --}}
                <h5 class="text-brown mb-3 fw-bold">Informasi Produk</h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control form-control-lg" 
                               value="{{ old('nama_produk') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kayu</label>
                        <select name="jenis_kayu" class="form-select form-select-lg" required>
                            <option value="" disabled selected>Pilih Jenis Kayu</option>
                            @foreach ($jenisKayuList as $kayu)
                                <option value="{{ $kayu }}" {{ old('jenis_kayu') == $kayu ? 'selected' : '' }}>
                                    {{ $kayu }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Produk</label>
                    <input type="file" name="gambar" class="form-control form-control-lg" accept="image/*" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control form-control-lg">{{ old('deskripsi') }}</textarea>
                </div>

                {{-- VARIAN PRODUK --}}
                <hr>
                <h5 class="text-brown text-center mb-4 fw-bold">Varian Produk</h5>

                <div id="variant-wrapper">

                    {{-- VARIANT DEFAULT --}}
                    <div class="variant-item border rounded-3 p-3 mb-3 bg-light">

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Ukuran</label>
                                <input type="text" name="variants[0][ukuran]" class="form-control" placeholder="Contoh: 2 x 16 x 2 m" required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Stok</label>
                                <input type="number" name="variants[0][stok]" class="form-control" placeholder="0" min="0" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Harga Satuan (Rp)</label>
                                <input type="number" name="variants[0][harga]" class="form-control" placeholder="Harga satuan" min="0" required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Harga/m³ (Rp)</label>
                                <input type="number" name="variants[0][harga_m3]" class="form-control" placeholder="Harga per m³" min="0" required>
                            </div>

                            <div class="col-md-2 d-flex align-items-end justify-content-end">
                                <button type="button" class="btn btn-danger btn-sm remove-variant d-none">Hapus</button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-end mb-4">
                    <button type="button" class="btn btn-success btn-sm px-4" id="add-variant">
                        + Tambah Varian
                    </button>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-brown w-100 py-2 rounded-3 fw-bold">
                        💾 Simpan Produk
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
        let variantIndex = 1;
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

                    <div class="col-md-2">
                        <label class="form-label">Harga/m³ (Rp)</label>
                        <input type="number" name="variants[${variantIndex}][harga_m3]" class="form-control" min="0" required>
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
