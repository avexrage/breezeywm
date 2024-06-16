<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        th, td { border: 1px solid black; padding: 8px; }
        th { text-align: left; }
        /* Ensure the table, th, and td elements have solid borders */
        table, th, td {
            border: 1px solid black;
        }
    </style>

</head>
<body>
    <div class="header">
        <h2>Yayasan Wredha Mulya</h2>
        <p>Jl. Sendowo B G, RT.13/RW.56, Sendowo, Sinduadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</p>
        <p>Telepon: 0822-2355-0029</p>
    </div>

    <h2>Bukti Pendaftaran</h2>
    <p>Tanggal Transaksi: {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d-m-Y') }}</p>
    <p>ID Transaksi: {{ $transaksi->id }}</p>
    <p>Penanggung Jawab: {{ $pendaftaran->peserta->user->nama }}</p>
    <p>Nama Peserta: {{ $pendaftaran->peserta->nama_lengkap_peserta }}</p>
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
    

</body>
</html>
