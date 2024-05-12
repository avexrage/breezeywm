<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card text-center">
            <div class="card-header bg-success text-white">
                Verifikasi Email Anda
            </div>
            <div class="card-body mt-3">
                <p>Email Sudah dikirim ke email anda. Cek email dan klik tombol Verifikasi Email</p>
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link">Kirim Ulang Email Verifikasi</button>
                </form>
            </div>
            <div class="card-footer text-muted">
                <p>&copy; 2024 - Yayasan Wredha Mulya</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-Ka7aDm3yEXyTCyMNCv9fEy+sB5qn54khB2o3UIBUjE9jkU+W9QzX0n5KU5Tqynq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ppxlZ7VFOQtYkMBz6i53y2+6xYVjCOoBb55ybsxl3qAqnre/Fkh/yQpG3z79i7k" crossorigin="anonymous"></script>
</body>
</html>

