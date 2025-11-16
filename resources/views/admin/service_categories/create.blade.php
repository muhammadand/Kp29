@extends('admin.layouts.base')

@section('title', 'Tambah Kategori Layanan')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold text-primary mb-4">Tambah Kategori Layanan</h3>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <strong>Form Tambah Kategori</strong>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.service-categories.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"> {{-- Penting untuk upload file --}}
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Kategori</label>
                    <input type="file" name="image" class="form-control">
                    <small class="text-muted">Format: jpg, jpeg, png | Maksimal 2MB</small>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.service-categories.index') }}" class="btn btn-light me-2">
                        Kembali
                    </a>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
