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
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <!-- Jam di pojok kiri -->
            <span class="navbar-text me-auto">
                <i class="bi bi-clock"></i> <span id="current-time"></span>
            </span>

            <!-- Profil Admin di pojok kanan -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Halo, {{ Auth::guard('admin')->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item" href="{{ route('adminlogout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('adminlogout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="text-dark" id="sidebar">
            <div class="p-3 text-start">
                <div class="d-flex justify-content-center mb-3">
                    <img src="{{ asset('images/ywm.png') }}" alt="Logo" style="width: 100px; height: auto;">
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('admin') ? 'active' : '' }}" href="{{ route('admin')}}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('datapdftr') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#dataPendaftaranSubmenu" aria-expanded="false">
                            <i class="bi bi-clipboard-data"></i> Data Pendaftaran
                        </a>
                        <ul class="collapse list-unstyled" id="dataPendaftaranSubmenu">
                            <li><a class="nav-link text-dark" href="{{ route('datapdftrday') }}"><i class="bi bi-circle"></i> Day Care</a></li>
                            <li><a class="nav-link text-dark" href="{{ route('datapdftrgrha') }}"><i class="bi bi-circle"></i> Grha Wredha Mulya</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('datapbyrn') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#dataPembayaranSubmenu" aria-expanded="false">
                            <i class="bi bi-credit-card"></i> Data Pembayaran
                        </a>
                        <ul class="collapse list-unstyled" id="dataPembayaranSubmenu">
                            <li><a class="nav-link text-dark" href="{{ route('datapbyrday') }}"><i class="bi bi-circle"></i> Day Care</a></li>
                            <li><a class="nav-link text-dark" href="{{ route('datapbyrgrha') }}"><i class="bi bi-circle"></i> Grha Wredha Mulya</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('datapeserta') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#dataPesertaSubmenu" aria-expanded="false">
                            <i class="bi bi-people"></i> Data Peserta
                        </a>
                        <ul class="collapse list-unstyled" id="dataPesertaSubmenu">
                            <li><a class="nav-link text-dark" href="{{ route('datapsrtday') }}"><i class="bi bi-circle"></i> Day Care</a></li>
                            <li><a class="nav-link text-dark" href="{{ route('datapsrtgrha') }}"><i class="bi bi-circle"></i> Grha Wredha Mulya</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-3" id="adminmain-content">
            <!-- Breadcrumb Section -->
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="breadcrumb-container bg-white shadow-sm rounded px-2 py-2 mb-2">
                        @yield('breadcrumb')
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        // Update the current time every second
        function updateTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
