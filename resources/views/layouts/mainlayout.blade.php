<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayasan Wredha Mulya | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-body-light fixed-top navbar-white shadow-sm">
    <div class="container-fluid">
        <a><img src="{{ asset('images/ywm.jpg') }}" alt="Yayasan Wredha Mulya Logo" width="70" height="64" class="me-auto"></a>
        <a class="navbar-brand navbar-brand-vertical text-success custom-margin" href="{{ route('home') }}">
            <span class="brand-top">Yayasan</span>
            <span class="brand-bottom">Wredha Mulya</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav"> 
                <li class="nav-item">
                    <a class="nav-link text-success" href="/#program">Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success" href="/#fasilitas">Fasilitas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success" href="/#kontakkami">Kontak Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success" href="{{ route('daftar') }}">Pendaftaran</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-success" href="{{ route('bayarday') }}">Pembayaran</a>
              </li>
            </ul> 
        </div>
        <div class="button-container">
            @guest
                <button type="button" class="btn btn-success btn-fixed" onclick="window.location='{{ route('login') }}'">Login</button>
                <button type="button" class="btn btn-outline-success btn-fixed" onclick="window.location='{{ route('register') }}'">Register</button>
            @endguest
            @auth
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i> {{ Auth::user()->email }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="{{ route('riwayat') }}">Riwayat Pendaftaran</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fa fa-power-off"></i> Log Out</a></li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</nav>
<!-- Logout Confirmation Modal -->
<div class="modal" tabindex="-1" id="logoutModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Logout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda ingin logout?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
          <a href="{{ route('actionlogout') }}" class="btn btn-success">Ya</a>
        </div>
      </div>
    </div>
  </div>
  
<div id="main-content" class=" flex-grow-1 pt-5 mt-5">
    @yield('content1') 
    @yield('content2')
    @yield('content3')
    @yield('content4')
    @yield('content5')
    @yield('content6')
    @yield('content0')
    @yield('content00')
</div>

<!-- Kontak Kami -->
<section id="kontakkami" class="bg-white shadow">
  <div id="notification" style="display: none;">Email berhasil dicopy!</div>

  <div class="container ">
    <footer class="py-0">
      <div class="row">
        <!-- Navigasi di sisi kiri -->
        <div class="col-md-8">
          <ul class="nav">
            <li class="nav-item"><a href="https://www.youtube.com/@wredhamulyatv2114" class="nav-link px-2 text-body-secondary"><i class="bi bi-youtube"></i></a></li>
            <li class="nav-item"><a href="https://wa.me/+6282223550029" class="nav-link px-2 text-body-secondary"><i class="bi bi-whatsapp"></i></a></li>
            <li class="nav-item"><a href="https://www.instagram.com/ywm_yogyakarta2023" class="nav-link px-2 text-body-secondary"><i class="bi bi-instagram"></i></a></li>
            <li class="nav-item"><a href="#" id="copy-email" data-email="wredhamulya@gmail.com" class="nav-link px-2 text-body-secondary"><i class="bi bi-envelope-open"></i></a></li>
            <li class="nav-item"><a href="https://www.facebook.com/profile.php?id=61550851776071&locale=id_ID" class="nav-link px-2 text-body-secondary"><i class="bi bi-facebook"></i></a></li>
          </ul>
        </div>
        <!-- Google Maps di sisi kanan -->
        <div class="col-md-4">
            <div class="map-and-address d-flex">
                <div class="map-container flex-grow-1">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1607269115775!2d110.36800507500483!3d-7.772775492246635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a58490c876c3b%3A0x9fff4c9758d746cc!2sYayasan%20Wredha%20Mulya%20Yogyakarta!5e0!3m2!1sid!2sid!4v1712739229389!5m2!1sid!2sid" frameborder="0" style="width: 100%; height: 100%;" allowfullscreen="" aria-hidden="false" tabindex="0"> </iframe>
                </div>
                
            </div>
        </div>
      <p class="text-center text-body-secondary ">&copy; 2024 Created by Maulana Faris</p>
    </footer>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@vite('resources/js/app.js')
</body>
</html>