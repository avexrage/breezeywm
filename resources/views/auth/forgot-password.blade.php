<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lupa Password | Yayasan Wredha Mulya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
   
<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-center text-white fs-5">{{ __('Lupa Password') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="text-center">Silahkan masukkan alamat email anda. Jika email terdaftar, maka kami akan mengirimkan email untuk mereset password anda. Setelah klik tombol kirim, silahkan cek email anda dan klik tombol reset password</label>
                            <label for="email" class="form-label">{{ __('Masukkan Email:') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('login') }}" class="text-success">Kembali ke Login</a>
                            <button type="submit" class="btn btn-success">
                                {{ __('Kirim Link Reset Password ') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
</body>
</html>