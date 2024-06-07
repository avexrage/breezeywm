@extends('admin.mainlayout')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="row w-100">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div>
                <h1 class="display-4">Login</h1>
                <p class="lead">Yayasan Wredha Mulya</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Silahkan Masukkan Informasi Akun Anda</h5>
                    <form action="{{ route('adminloginpost') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
