@extends('admin.layouts.base')

@section('title', 'Tambah Item Layanan')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold text-primary mb-4">Tambah Item Layanan</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.service-items.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Pilih Kategori --}}
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Item --}}
                <div class="mb-3">
                    <label class="form-label">Nama Item</label>
                    <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control" name="price" required value="{{ old('price') }}">
                </div>

                {{-- Unit --}}
                <div class="mb-3">
                    <label class="form-label">Unit (opsional)</label>
                    <input type="text" class="form-control" name="unit" placeholder="ex: per m³" value="{{ old('unit') }}">
                </div>

                {{-- Upload Gambar --}}
                <div class="mb-3">
                    <label class="form-label">Gambar Item</label>
                    <input type="file" class="form-control" name="image">
                    <small class="text-muted">Format: jpg, jpeg, png | Maksimal 2MB</small>
                </div>

                <div class="mt-3">
                    <a href="{{ route('admin.service-items.index') }}" class="btn btn-light">Kembali</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
