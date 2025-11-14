@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')

<!-- Hero Section -->
<div class="hero" style="margin-bottom: 100px;">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-5">
        <div class="intro-excerpt">
          <h1>Tentang PD. Kurnia Jaya</h1>
          <p class="mb-4">
            PD. Kurnia Jaya adalah penyedia kayu berkualitas untuk kebutuhan konstruksi, furnitur, dan industri.
            Kami berkomitmen memberikan produk kayu terbaik dengan harga bersaing dan layanan yang profesional.
          </p>
          <p>
            <a href="{{ url('/contact') }}" class="btn btn-white-outline">Hubungi Kami</a>
          </p>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="hero-img-wrap text-end">
          <img src="{{ asset('landing-page/images/kayu-hero.jpg') }}" class="img-fluid" alt="Kayu Berkualitas">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Hero Section -->

<!-- Why Choose Us Section -->
<div class="why-choose-section" style="margin-bottom: 100px;">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-6">
        <h2 class="section-title">Mengapa Memilih Kami</h2>
        <p>
          Kami menyediakan kayu yang sudah melalui proses seleksi ketat, legal bersertifikasi, dan siap dikirim ke seluruh wilayah.
          Layanan kami cepat, aman, dan terpercaya untuk berbagai skala kebutuhan kayu.
        </p>

        <div class="row my-5">
          <div class="col-6 col-md-6">
            <div class="feature text-center">
              <div class="icon mb-3">
                <img src="{{ asset('landing-page/images/truck.svg') }}" alt="Pengiriman Cepat" class="img-fluid">
              </div>
              <h3>Pengiriman Cepat</h3>
              <p>Kami pastikan kayu sampai ke lokasi Anda tepat waktu dan aman.</p>
            </div>
          </div>

          <div class="col-6 col-md-6">
            <div class="feature text-center">
              <div class="icon mb-3">
                <img src="{{ asset('landing-page/images/box.svg') }}" alt="Produk Berkualitas" class="img-fluid">
              </div>
              <h3>Produk Berkualitas</h3>
              <p>Kayu pilihan terbaik dengan kualitas terjamin untuk semua kebutuhan.</p>
            </div>
          </div>

          <div class="col-6 col-md-6">
            <div class="feature text-center">
              <div class="icon mb-3">
                <img src="{{ asset('landing-page/images/support.svg') }}" alt="Layanan Support" class="img-fluid">
              </div>
              <h3>Layanan Support 24/7</h3>
              <p>Tim kami siap membantu konsultasi dan pemesanan kapan saja.</p>
            </div>
          </div>

          <div class="col-6 col-md-6">
            <div class="feature text-center">
              <div class="icon mb-3">
                <img src="{{ asset('landing-page/images/return.svg') }}" alt="Kebijakan Mudah" class="img-fluid">
              </div>
              <h3>Kebijakan Fleksibel</h3>
              <p>Mudah dalam retur atau penggantian produk jika terjadi masalah.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="img-wrap text-center">
          <img src="{{ asset('landing-page/images/warehouse.jpg') }}" alt="Gudang Kayu" class="img-fluid rounded">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Why Choose Us Section -->

<!-- Team Section -->
<div class="untree_co-section py-5" style="background-color: #f8f9fa;">
  <div class="container">

    <!-- Title -->
    <div class="row mb-5">
      <div class="col-lg-6 mx-auto text-center">
        <h2 class="section-title">Tim Kami</h2>
        <p class="text-muted">Bertemu dengan orang-orang hebat di balik kesuksesan PD. Kurnia Jaya.</p>
      </div>
    </div>

    <!-- Team Members -->
    <div class="row justify-content-center">

      <!-- Team Member 1 -->
      <div class="col-12 col-md-6 col-lg-4 mb-4 d-flex justify-content-center">
        <div class="card border-0 shadow-lg text-center p-4" style="border-radius: 20px;">
          <img src="{{ asset('landing-page/images/person_1.jpg') }}" 
               class="rounded-circle mx-auto mb-3" 
               style="width: 150px; height: 150px; object-fit: cover;">
          <h4 class="fw-bold mb-1">Budi Santoso</h4>
          <span class="text-muted d-block mb-3">CEO & Founder</span>
          <p class="text-muted">
            Memimpin PD. Kurnia Jaya dengan pengalaman bertahun-tahun di industri kayu dan konstruksi.
          </p>
          <a href="#" class="btn btn-outline-dark btn-sm px-4 rounded-pill">Learn More</a>
        </div>
      </div>

      <!-- Team Member 2 -->
      <div class="col-12 col-md-6 col-lg-4 mb-4 d-flex justify-content-center">
        <div class="card border-0 shadow-lg text-center p-4" style="border-radius: 20px;">
          <img src="{{ asset('landing-page/images/person_2.jpg') }}" 
               class="rounded-circle mx-auto mb-3" 
               style="width: 150px; height: 150px; object-fit: cover;">
          <h4 class="fw-bold mb-1">Siti Rahma</h4>
          <span class="text-muted d-block mb-3">Co-Founder & Manager Operasional</span>
          <p class="text-muted">
            Bertanggung jawab mengelola operasi gudang dan pengiriman produk kayu berkualitas.
          </p>
          <a href="#" class="btn btn-outline-dark btn-sm px-4 rounded-pill">Learn More</a>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- End Team Section -->

@endsection
