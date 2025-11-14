@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>
                        Penjualan Kayu Berkualitas
                        <span class="d-block">PD. Kurnia Jaya</span>
                    </h1>
                    <p class="mb-4">
                        Menyediakan berbagai jenis kayu seperti Jati, Meranti, Kamper,
                        dan lainnya dengan kualitas yang terjamin dan harga yang bersaing.
                        Cocok untuk kebutuhan bangunan, furnitur, dan industri.
                    </p>
                    <p>
                        <a href="{{ url('/shop') }}" class="btn btn-secondary me-2">Lihat Produk</a>
                        <a href="{{ url('/about') }}"class="btn btn-secondary Button">Tentang Kami</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap">
                    <img
                        src="{{ asset('landing-page/images/Tumpukan1.png') }}"
                        class="img-fluid"
                        alt="Kayu"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<!-- Start About / We Help Section -->
<div class="we-help-section">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="imgs-grid">
                    <div class="grid grid-1">
                        <img
                            src="{{ asset('landing-page/images/gudaang.jpg') }}"
                            alt="Gudang Kayu"
                        />
                    </div>

                    <div class="grid grid-2">
                        <img
                            src="{{ asset('landing-page/images/Tumpukan2.png') }}"
                            alt="Tumpukan Kayu"
                        />
                    </div>

                    <div class="grid grid-3">
                        <img
                            src="{{ asset('landing-page/images/ngolahkayyu.jpg') }}"
                            alt="Proses Pengolahan Kayu"
                        />
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ps-lg-5">
                <h2 class="section-title mb-4">
                    Solusi Kebutuhan Kayu Anda
                </h2>
                <p>
                    PD. Kurnia Jaya telah berpengalaman dalam menyediakan kayu
                    berkualitas untuk berbagai kebutuhan konstruksi, industri, dan furnitur.
                    Kayu yang kami sediakan dipilih dengan proses seleksi terbaik.
                </p>

                <ul class="list-unstyled custom-list my-4">
                    <li>Kualitas kayu terjamin dan legal bersertifikasi</li>
                    <li>Harga bersaing dan fleksibel untuk pembelian besar</li>
                    <li>Pengiriman cepat dan aman</li>
                    <li>Tersedia berbagai jenis dan ukuran kayu</li>
                </ul>
                <p><a href="#" class="btn">Pelajari Lebih Lanjut</a></p>
            </div>
        </div>
    </div>
</div>
<!-- End We Help Section -->

@endsection
