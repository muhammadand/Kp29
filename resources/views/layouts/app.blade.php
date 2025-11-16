<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landing-page/css/bootstrap.min.css') }}" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Tiny Slider -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landing-page/css/tiny-slider.css') }}" />

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landing-page/css/style.css') }}" />

    <title>@yield('title', 'PD Kurnia Jaya')</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="navigation bar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('landing-page/images/logo KJ.png') }}" alt="PD Kurnia Jaya" style="height: 100px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('shop') ? 'active' : '' }}" href="{{ url('/shop') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ url('/about') }}">About us</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Request::is('services') ? 'active' : '' }}" href="{{ url('/services') }}">Services</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('services') ? 'active' : '' }}" href="{{ url('/services') }}">Service</a>
                    </li>
                      <li class="nav-item">
                        <a class="nav-link {{ Request::is('my-order') ? 'active' : '' }}" href="{{ url('/my-order') }}">My order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact Us</a>
                    </li>
                </ul>
            </div>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <!-- Jika pelanggan sudah login -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('landing-page/images/user.svg') }}" alt="User" />
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ url('/shop') }}">Toko</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                <!-- Jika pelanggan belum login -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <img src="{{ asset('landing-page/images/user.svg') }}" alt="User" />
                        </a>
                    </li>
                @endguest

                <!-- Keranjang -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/cart') }}">
                        <img src="{{ asset('landing-page/images/cart.svg') }}" alt="Cart" />
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->

    {{-- Tempat konten halaman lain ditampilkan --}}
    @yield('content')

    <!-- Footer -->
  
    <!-- End Footer -->

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('landing-page/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Tiny Slider -->
    <script src="{{ asset('landing-page/js/tiny-slider.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('landing-page/js/custom.js') }}"></script>
</body>
</html>
