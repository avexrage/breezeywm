<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pendaftaran</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 70px;
            height: 64px;
        }
        .header h2 {
            margin: 10px 0;
        }
        .header p {
            margin: 5px 0;
        }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { text-align: left; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <h2>Yayasan Wredha Mulya</h2>
        <p>Jl. Sendowo B G, RT.13/RW.56, Sendowo, Sinduadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</p>
        <p>Telepon: 0822-2355-0029</p>
    </div>

    <h2>Bukti Pendaftaran</h2>
    <p>Tanggal Transaksi: {{ $transaksi->tanggal_transaksi }}</p>
    <p>ID Transaksi: {{ $transaksi->id }}</p>
    <p>Penanggung Jawab: {{ $pendaftaran->dataPeserta->user->nama }}</p>
    <p>Nama Peserta: {{ $pendaftaran->dataPeserta->nama_lengkap_peserta }}</p>
    <p>Metode Pembayaran: {{ $pendaftaran->metode_pembayaran }}</p>
    <p>Status Pembayaran: {{ $transaksi->status_pembayaran }}</p>
    <h4>Detail Program</h4>
    <table>
        <thead>
            <tr>
                <th>Jenis Program</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programs as $program)
            <tr>
                <td>{{ $program->nama_program }}</td>
                <td>{{ \Carbon\Carbon::parse($program->pivot->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $program->pivot->tipe }}</td>
                <td>{{ number_format($program->pivot->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="3">Total Harga</th>
                <th>{{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
