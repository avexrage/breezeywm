<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="text-dark" id="sidebar" style="background-color: #C6EDC3">
            <div class="p-3 text-start">
                <div class="d-flex justify-content-center mb-3">
                    <img src="{{ asset('images/ywm.png') }}" alt="Logo" style="width: 100px; height: auto;"> <!-- Sesuaikan path logo -->
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('admin') ? 'active' : '' }}" href="{{ route('admin')}}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('datapdftr') ? 'active' : '' }}" href="{{ route('datapdftr')}}">
                            <i class="bi bi-clipboard-data"></i> Data Pendaftaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('datapembayaran') ? 'active' : '' }}" href="#">
                            <i class="bi bi-credit-card"></i> Data Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('datapeserta') ? 'active' : '' }}" href="#">
                            <i class="bi bi-people"></i> Data Peserta
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-3" id="main-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
