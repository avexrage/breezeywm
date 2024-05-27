<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar | Yayasan Wredha Mulya</title>
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
                  <div class="mb-1" style="font-size: 100px; font-weight:400">Daftar</div>
                </div>
              </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6 col-xl-6 rounded-start-5 shadow-sm " style="height: 100vh; background-color: #EAFCE9; ">
            <div class="d-flex align-items-center justify-content-center h-100" style="overflow-y:auto">
                <div class="w-50 rounded px-3 py-3" style="box-shadow: none; background-color: #EAFCE9"">
                
                <form action="{{ route('actionregister') }}" method="POST" style="border: ">
                @csrf
                    <div class="mb-3">
                        <p class="fw-semibold">Silahkan Masukkan Informasi Data Diri Anda</p> 
                    </div>
                    @include('layouts.pesan')
                    <div class="mb-3 rounded" style="border: none;">
                        <label class="form-label" for="nama">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ Session::get('nama') }}" style="text-transform: capitalize;">
                    </div>
                    <div class="mb-3 rounded" style="border: none;">
                        <label class="form-label" for="ktp">Nomor KTP</label>
                        <input type="text" name="ktp" class="form-control" placeholder="Masukkan Nomor KTP" value="{{ Session::get('ktp') }}">
                    </div>
                    <div class="mb-3 rounded" style="border: none;">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan Email" value="{{ Session::get('email') }}">
                    </div>
                    <div class="mb-3 rounded" style="border: none;">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password" >
                    </div>
                    <div class="mb-3 rounded" style="border: none;">
                        <label class="form-label" for="nohp">Nomor HP</label>
                        <input type="text" name="nohp" class="form-control" placeholder="Masukkan Nomor HP" value="{{ Session::get('no_hp') }}" style="text-transform: capitalize;">
                    </div>
                    <div class="mb-3 rounded" style="border: none;">
                        <label class="form-label" for="alamat">Alamat Lengkap</label>
                        <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat Lengkap" value="{{ Session::get('alamat') }}" style="text-transform: capitalize;">
                    </div>
                    <div class="mb-3 rounded" style="border: none;">
                        <label class="form-label" for="pekerjaan">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" placeholder="Masukkan Pekerjaan" value="{{ Session::get('pekerjaan') }}" style="text-transform: capitalize;">
                    </div>
                    <div class="my-3">
                        <label>Sudah punya akun? <a href="{{ route('login')}}" class="text-success link-underline-light">Login disini</a></label>
                    </div>
                    <button name="submit" type="submit" class="d-grid col-12 py-2 btn btn-success">Daftar</button>      
                </form>
                </div>
            </div>    
        </div>
    </div>
</div>    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
