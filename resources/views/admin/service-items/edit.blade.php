@extends('admin.layouts.base')

@section('title', 'Edit Item Layanan')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold text-primary mb-4">Edit Item Layanan</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.service-items.update', $item->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Pilih Kategori --}}
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="category_id" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" 
                                {{ $item->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Item --}}
                <div class="mb-3">
                    <label class="form-label">Nama Item</label>
                    <input type="text" class="form-control" name="name" 
                           value="{{ old('name', $item->name) }}" required>
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control" name="price" 
                           value="{{ old('price', $item->price) }}" required>
                </div>

                {{-- Unit --}}
                <div class="mb-3">
                    <label class="form-label">Unit</label>
                    <input type="text" class="form-control" name="unit" 
                           value="{{ old('unit', $item->unit) }}">
                </div>

                {{-- Upload Gambar --}}
                <div class="mb-3">
                    <label class="form-label">Gambar Item</label>

                    {{-- Preview gambar lama --}}
                    @if($item->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $item->image) }}" 
                                 alt="Gambar {{ $item->name }}" 
                                 class="img-thumbnail" 
                                 style="max-width: 150px;">
                        </div>
                    @endif

                    <input type="file" class="form-control" name="image">
                    <small class="text-muted">Format: jpg, jpeg, png | Maksimal 2MB. Upload baru untuk mengganti gambar lama.</small>
                </div>

                <div class="mt-3">
                    <a href="{{ route('admin.service-items.index') }}" class="btn btn-light">Kembali</a>
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
