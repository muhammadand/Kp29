@extends('admin.layouts.base')

@section('title', 'Tambah Produk')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm mx-auto" style="max-width: 800px;">
        <div class="card-header bg-brown text-white text-center">
            <h5>Tambah Produk Kayu</h5>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Data Produk Utama --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Kayu</label>
                        <select name="jenis_kayu" class="form-select" required>
                            <option value="" disabled {{ old('jenis_kayu') ? '' : 'selected' }}>Pilih Jenis Kayu</option>
                            @foreach ($jenisKayuList as $kayu)
                                <option value="{{ $kayu }}" {{ old('jenis_kayu') == $kayu ? 'selected' : '' }}>
                                    {{ $kayu }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi') }}</textarea>
                </div>

                {{-- Varian Produk --}}
                <hr>
                <h5 class="text-center mb-3 text-brown">Varian Produk</h5>

                <div id="variant-wrapper">
                    <div class="variant-item row g-3 mb-3">
                        <div class="col-md-4">
                            <input type="text" name="variants[0][ukuran]" class="form-control" placeholder="Ukuran (contoh: 2x16.2m)" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="variants[0][stok]" class="form-control" placeholder="Stok" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="variants[0][harga]" class="form-control" placeholder="Harga (Rp)" min="0" required>
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-variant d-none">✖</button>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-4">
                    <button type="button" class="btn btn-success btn-sm" id="add-variant">+ Tambah Varian</button>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-brown w-100">💾 Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Style --}}
<style>
    .bg-brown { background-color: #7b4f2b; }
    .text-brown { color: #7b4f2b; }
    .btn-brown { background-color: #7b4f2b; color: #fff; border-radius: 8px; border: none; transition: 0.3s; }
    .btn-brown:hover { background-color: #5c3b1e; color: #fff; }
</style>

{{-- Script Tambah/Hapus Varian --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let variantIndex = 1;
        const wrapper = document.getElementById('variant-wrapper');
        const addBtn = document.getElementById('add-variant');

        addBtn.addEventListener('click', function () {
            const newVariant = document.createElement('div');
            newVariant.classList.add('variant-item', 'row', 'g-3', 'mb-3');
            newVariant.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="variants[${variantIndex}][ukuran]" class="form-control" placeholder="Ukuran (contoh: 2x20.2m)" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="variants[${variantIndex}][stok]" class="form-control" placeholder="Stok" min="0" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="variants[${variantIndex}][harga]" class="form-control" placeholder="Harga (Rp)" min="0" required>
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-variant">✖</button>
                </div>
            `;
            wrapper.appendChild(newVariant);
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
