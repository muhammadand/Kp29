@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 450px;">
    <h3 class="text-center mb-4">Login Pelanggan</h3>

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Login</button>

        <p class="text-center mt-3">
            Belum punya akun? <a href="{{ route('register') }}">Register</a>
        </p>
    </form>
</div>
@endsection
