@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 450px;">
    <h3 class="text-center mb-4">Daftar Akun Pelanggan</h3>

    <form action="{{ route('register.process') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required placeholder="Masukkan email">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Buat password">
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
        </div>

        <button class="btn btn-primary w-100">Daftar</button>

        <p class="text-center mt-3">
            Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
        </p>

    </form>
</div>
@endsection
