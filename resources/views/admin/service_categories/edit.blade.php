@extends('admin.layouts.base')

@section('title', 'Edit Kategori Layanan')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold text-primary mb-4">Edit Kategori Layanan</h3>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <strong>Form Edit Kategori</strong>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.service-categories.update', $category->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data"> {{-- Penting untuk upload file --}}
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" required
                           value="{{ old('name', $category->name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Kategori</label>

                    {{-- Preview gambar lama jika ada --}}
                    @if($category->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="Gambar Kategori" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px;">
                        </div>
                    @endif

                    <input type="file" name="image" class="form-control">
                    <small class="text-muted">Format: jpg, jpeg, png | Maksimal 2MB. Upload baru untuk mengganti gambar lama.</small>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.service-categories.index') }}" class="btn btn-light me-2">
                        Kembali
                    </a>
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
