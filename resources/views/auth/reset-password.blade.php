<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password | Yayasan Wredha Mulya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head> 
    <body>
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @include('layouts.pesan')
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ request()->token }}">
                            <input type="hidden" name="email" value="{{ request()->email }}">
                            <div class="my-3">
                                <label for="password" class="form-label">{{ __('Masukkan Password Baru:') }}</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required autocomplete="new-password">

                            </div>
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">{{ __('Konfirmasi Password:') }}</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password-confirm" required autocomplete="new-password">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Ubah Password') }}
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