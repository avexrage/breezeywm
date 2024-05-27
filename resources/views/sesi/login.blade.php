<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Yayasan Wredha Mulya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex col text-center align-items-center justify-content-center" style=" height: 100vh;">        
                <div class="card" style="border: none">
                    <div class="card-body">
                      <div class="mb-1" style="font-size: 100px; font-weight:400">Login</div>
                      <a href="{{ route('home') }}" class="btn btn-success">Yayasan Wredha Mulya</a>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-md-8 col-lg-6 col-xl-6 rounded-start-5 shadow-sm" style="height: 100vh; background-color: #EAFCE9">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="w-50 rounded px-3 py-3" style="box-shadow: none; background-color: #EAFCE9"">
                        @include('layouts.pesan')
                        <form action="{{ route('actionlogin') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <p class="fw-semibold">Silahkan Masukkan Informasi Akun Anda</p> 
                        </div>
                        <div class="mb-3 rounded" style="border: none;">
                            <label class=" form-label" for="email">Email</label>
                            <input type="email" value="{{ Session::get('email')}} " name="email" class="form-control" placeholder="Masukkan Email " >
                        </div>
                        <div class="mb-3 rounded" style="border: none;">
                            <label class="form-label" for="email">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password " >
                        </div>
                        @php
                            $num1 = rand(1, 9);
                            $num2 = rand(1, 9);
                            Session::put('captcha', $num1 + $num2);
                        @endphp
                        <div class="mb-3">
                            <label for="captcha">Berapa {{ $num1 }} + {{ $num2 }}?</label>
                            <input type="text" name="captcha" class="form-control" placeholder="Jawab" required>
                        </div>
                        <div class="d-flex justify-content-between my-3">
                            <div>
                                <label>Tidak punya akun? <a href="{{ route('register')}}" class="text-success link-underline-light">Daftar disini</a></label>
                            </div>
                            <div>
                                <a href="{{ route('password.request') }}" class="text-success link-underline-light">Lupa password?</a>
                            </div>
                        </div>
                            <button name="submit" type="submit" class="btn btn-success btn-fixed">Login</button>      
                        </form>
                    </div>    
                </div>
            </div>
        </div>    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


