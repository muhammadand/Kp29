@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero" style="margin-bottom: 230px;">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-5">
        <div class="intro-excerpt">
          <h1>Contact</h1>
          <p class="mb-4">Silakan hubungi kami kapan saja.</p>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="hero-img-wrap text-end">
          <img src="{{ asset('landing-page/images/couch.png') }}" class="img-fluid" alt="Hero Image">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Contact Section -->
<div class="container pb-5">
  <div class="row g-4 align-items-start">
    <!-- Google Maps -->
    <div class="col-md-6">
      <div class="shadow-lg rounded overflow-hidden" style="height: 450px;">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193571.43842445882!2d-74.118086!3d40.705825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c250b589d4b1cd%3A0x1293628c8b1a7f35!2sNew%20York!5e0!3m2!1sen!2sus!4v1676206160226!5m2!1sen!2sus"
          width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="col-md-6">
      <div class="p-4 shadow rounded">
        <form>
          <div class="mb-3">
            <input type="text" class="form-control" placeholder="Your Name">
          </div>
          <div class="mb-3">
            <input type="email" class="form-control" placeholder="Your Email">
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" placeholder="Subject">
          </div>
          <div class="mb-4">
            <textarea rows="5" class="form-control" placeholder="Message"></textarea>
          </div>
          <button type="submit" class="btn w-100" style="background-color:#d39e00; color:white;">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
